package cz.monetplus.mips.eapi.v10hu.modes;

import cz.monetplus.mips.eapi.v10hu.ArgsConfig;
import cz.monetplus.mips.eapi.v10hu.ArgsConfig.RunModeEnum;
import cz.monetplus.mips.eapi.v10hu.RunMode;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.EchoCustomerResponse;
import cz.monetplus.mips.eapi.v10hu.service.ExamplesService;
import cz.monetplus.mips.eapi.v10hu.service.MipsException;
import cz.monetplus.mips.eapi.v10hu.service.RespCode;
import lombok.extern.slf4j.Slf4j;
import org.apache.commons.lang.StringUtils;
import org.springframework.stereotype.Component;

@Component
@Slf4j
public class CustomerEchoMode implements RunMode {

	private final ExamplesService examplesService;

	public CustomerEchoMode(ExamplesService examplesService) {
		this.examplesService = examplesService;
	}

	@Override
	public void proc(ArgsConfig aConfig) {

		try {
			if (StringUtils.trimToNull(aConfig.customerId) == null) {
				throw new MipsException(RespCode.INVALID_PARAM, "Missing mandatory parameter customerId");
			}
			EchoCustomerResponse res = examplesService.echoCustomer(aConfig.customerId);
			log.info("result code: {} [{}]", res.resultCode, res.resultMessage);
			
		} catch (Exception e) {
			throw new RuntimeException(e);
		} 
		
	}

	@Override
	public RunModeEnum getMode() {
		return RunModeEnum.ECHO_CUSTOMER;
	}

}
