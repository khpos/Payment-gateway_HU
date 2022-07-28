package cz.monetplus.mips.eapi.v10hu;

import cz.monetplus.mips.eapi.v10hu.ArgsConfig.RunModeEnum;

public interface RunMode {

	void proc(ArgsConfig aConfig);
	
	RunModeEnum getMode();
}
