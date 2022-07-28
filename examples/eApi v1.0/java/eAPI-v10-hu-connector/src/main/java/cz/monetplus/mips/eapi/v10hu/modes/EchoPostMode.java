package cz.monetplus.mips.eapi.v10hu.modes;

import cz.monetplus.mips.eapi.v10hu.ArgsConfig;
import cz.monetplus.mips.eapi.v10hu.ArgsConfig.RunModeEnum;
import cz.monetplus.mips.eapi.v10hu.RunMode;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.EchoResponse;
import cz.monetplus.mips.eapi.v10hu.service.ExamplesService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.stereotype.Component;

@Component
@Slf4j
public class EchoPostMode implements RunMode {

	private final ExamplesService examplesService;

	public EchoPostMode(ExamplesService examplesService) {
		this.examplesService = examplesService;
	}

	@Override
	public void proc(ArgsConfig aConfig) {
		try {
			EchoResponse res = examplesService.echoPost();
			log.info("result code: {} [{}]", res.resultCode, res.resultMessage);
			
		} catch (Exception e) {
			throw new RuntimeException(e);
		} 
	}

	@Override
	public RunModeEnum getMode() {
		return RunModeEnum.ECHO_POST;
	}

}
