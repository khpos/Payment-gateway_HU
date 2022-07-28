package cz.monetplus.mips.eapi.v10hu;


import org.springframework.boot.ExitCodeGenerator;

public class StaticExitCodeGenerator implements ExitCodeGenerator{

	private final int exitCode;
	
	public StaticExitCodeGenerator(int exitCode) {
		this.exitCode = exitCode;
	}

	@Override
	public int getExitCode() {
		return exitCode;
	}

}
