package cz.monetplus.mips.eapi.v10hu.service;

import cz.monetplus.mips.eapi.v10hu.connector.entity.SignBase;


public interface CryptoService {

	/**
	 * 
	 * @param signBase
	 * @return
	 */
	boolean isSignatureValid(SignBase signBase);

	/**
	 * 
	 * @param signBase
	 * @throws MipsException
	 */
	void createSignature(SignBase signBase) throws MipsException;
	
}
