package cz.monetplus.mips.eapi.v10hu.service;

import org.aspectj.lang.ProceedingJoinPoint;
import org.aspectj.lang.annotation.Around;
import org.aspectj.lang.annotation.Aspect;
import org.springframework.stereotype.Component;

import cz.monetplus.mips.eapi.v10hu.connector.entity.SignBase;
import lombok.extern.slf4j.Slf4j;


@Aspect
@Component
@Slf4j
public class SignedApiMethodAspect {
  private final CryptoService cryptoService;

    public SignedApiMethodAspect(CryptoService cryptoService) {
        this.cryptoService = cryptoService;
    }

    @Around("@annotation(cz.monetplus.mips.eapi.v10hu.service.SignedApiMethod)")
  public Object processSignatures(ProceedingJoinPoint joinPoint) throws Throwable{
    Object[] args = joinPoint.getArgs();
    for(Object arg : args) {
       if(arg instanceof SignBase)   {
        cryptoService.createSignature((SignBase)arg);
       }
    }
    Object result = joinPoint.proceed();
    if(result instanceof SignBase) {
        SignBase signed = (SignBase)result;
        if (!cryptoService.isSignatureValid(signed)) {
            throw new MipsException(RespCode.INTERNAL_ERROR, "Invalid signature for response " + signed.toJson()); 
        }
    }
    return result;
   
  }
}
