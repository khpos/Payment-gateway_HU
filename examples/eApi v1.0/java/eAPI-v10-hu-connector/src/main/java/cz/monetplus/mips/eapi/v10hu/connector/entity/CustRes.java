package cz.monetplus.mips.eapi.v10hu.connector.entity;

import javax.xml.bind.annotation.XmlAccessType;
import javax.xml.bind.annotation.XmlAccessorType;
import javax.xml.bind.annotation.XmlElement;
import javax.xml.bind.annotation.XmlRootElement;

@XmlRootElement
@XmlAccessorType(XmlAccessType.FIELD)
public class CustRes extends SignBase {

	private static final long serialVersionUID = -3825192932302805075L;
	
	@XmlElement
	public String customerId;

	@XmlElement
	public int resultCode;

	@XmlElement
	public String resultMessage;

	@Override
	public String toSign() {
		StringBuilder sb = new StringBuilder(); 
		add(sb, customerId);
		add(sb, dttm);
		add(sb, resultCode);
		add(sb, resultMessage);
		deleteLast(sb);
		return sb.toString();
	}

}
