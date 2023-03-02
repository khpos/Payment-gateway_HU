package cz.monetplus.mips.eapi.v10hu.modes;

import cz.monetplus.mips.eapi.v10hu.ArgsConfig;
import cz.monetplus.mips.eapi.v10hu.ArgsConfig.RunModeEnum;
import cz.monetplus.mips.eapi.v10hu.RunMode;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.PaymentInitResponse;
import cz.monetplus.mips.eapi.v10hu.service.ExamplesService;
import cz.monetplus.mips.eapi.v10hu.service.MipsException;
import cz.monetplus.mips.eapi.v10hu.service.RespCode;
import lombok.extern.slf4j.Slf4j;
import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Component;

import java.io.File;

@Component
@Slf4j
public class PaymentInitMode implements RunMode {


	private final ExamplesService examplesService;

	public PaymentInitMode(ExamplesService examplesService) {
		this.examplesService = examplesService;
	}

	@Override
	public void proc(ArgsConfig aConfig) {
		
		try {
			if (StringUtils.trimToNull(aConfig.initFile) == null) {
				throw new MipsException(RespCode.INVALID_PARAM, "Missing mandatory parameter initFile");
			}
			File f = new File(aConfig.initFile);
			if (!f.isFile() || !f.canRead()) {
				throw new IllegalArgumentException("Unable to load initFile " + f.getAbsolutePath());
			}
			
			PaymentInitResponse res = examplesService.paymentInit(f);
			log.info("result code: {} [{}], payment status {}, payId {}", res.getResultCode(), res.getResultMessage(), res.getPaymentStatus(), res.getPayId());
			if (!StringUtils.isBlank(res.getCustomerCode())) {
				log.info("Custom payment initialized, customer code {}, finish payment via https://(i)platebnibrana.csob.cz/zaplat/{}", res.getCustomerCode(), res.getCustomerCode());
			}

			
		} catch (Exception e) {
			throw new RuntimeException(e);
		} 
	}

	@Override
	public RunModeEnum getMode() {
		return RunModeEnum.PAYMENT_INIT;
	}

}
