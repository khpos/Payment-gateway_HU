package cz.monetplus.mips.eapi.v10hu.modes;

import cz.monetplus.mips.eapi.v10hu.ArgsConfig;
import cz.monetplus.mips.eapi.v10hu.RunMode;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.GooglepayEchoResponse;
import cz.monetplus.mips.eapi.v10hu.service.ExamplesService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Component;

@Slf4j
@Component
public class GooglepayEchoMode implements RunMode {
    private final ExamplesService examplesService;

    public GooglepayEchoMode(ExamplesService examplesService) {
        this.examplesService = examplesService;
    }

    @Override
    public void proc(ArgsConfig aConfig) {
        try {
            GooglepayEchoResponse res = examplesService.googlepayEcho();
            log.info("result code: {} [{}]", res.getResultCode(), res.getResultMessage());
        } catch(Exception e) {
            throw new RuntimeException(e);
        }
    }

    @Override
    public ArgsConfig.RunModeEnum getMode() {
        return ArgsConfig.RunModeEnum.GOOGLEPAY_ECHO;
    }
}
