package cz.monetplus.mips.eapi.v10hu.connector.entity.responses;

import cz.monetplus.mips.eapi.v10hu.connector.entity.SignBase;
import cz.monetplus.mips.eapi.v10hu.connector.entity.ext.Extension;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;

import java.util.List;

@EqualsAndHashCode(callSuper = false)
@Data
@AllArgsConstructor
@NoArgsConstructor
public class OneclickEchoResponse extends SignBase {

	private static final long serialVersionUID = -3825192932302805075L;
	
	private String origPayId;
	private int resultCode;
	private String resultMessage;
	private List<Extension> extensions;


	@Override
	public String toSign() {
		StringBuilder sb = new StringBuilder(); 
		add(sb, origPayId);
		add(sb, dttm);
		add(sb, resultCode);
		add(sb, resultMessage);
		deleteLast(sb);
		return sb.toString();
	}

}
