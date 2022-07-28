package cz.monetplus.mips.eapi.v10hu.connector.entity;


public class EchoRequest extends SignBase {

	private static final long serialVersionUID = -3825192932302805075L;
	
	public String merchantId;
	
	public EchoRequest() {
	}
	
	public EchoRequest(String merchantId) {
		this.merchantId = merchantId;
	}

	@Override
	public String toSign() {
		StringBuilder sb = new StringBuilder(); 
		add(sb, merchantId);
		add(sb, dttm);
		deleteLast(sb);
		return sb.toString();
	}

}
