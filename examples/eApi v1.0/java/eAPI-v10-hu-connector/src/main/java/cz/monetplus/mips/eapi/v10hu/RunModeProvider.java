package cz.monetplus.mips.eapi.v10hu;

import cz.monetplus.mips.eapi.v10hu.ArgsConfig.RunModeEnum;

public interface RunModeProvider {
	
	/**
	 * Finds run mode by name
	 * @param mode
	 * @return
	 */
	RunMode find(RunModeEnum mode);

}
