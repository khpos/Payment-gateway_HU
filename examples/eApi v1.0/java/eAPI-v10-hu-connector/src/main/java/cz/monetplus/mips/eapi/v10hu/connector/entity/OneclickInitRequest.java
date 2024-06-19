package cz.monetplus.mips.eapi.v10hu.connector.entity;

import java.util.List;

import cz.monetplus.mips.eapi.v10hu.connector.entity.ext.Extension;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.RequiredArgsConstructor;

@EqualsAndHashCode(callSuper = false)
@Data
@AllArgsConstructor @RequiredArgsConstructor
public class OneclickInitRequest extends SignBase  {
	private String merchantId;
	private String origPayId;
	private String orderNo;
	private String payMethod; //[card, card#LVP]
	private String clientIp;
	private Long totalAmount;
	private String currency;
	private Boolean closePayment;
	private String returnUrl;
	private String returnMethod;
	private Customer customer;
	private Order order;
	private Boolean clientInitiated;
	private Boolean sdkUsed;
	private String merchantData;
	private List<Extension> extensions;
	private Integer ttlSec;

	@Override
	public String toSign() {
		StringBuilder sb = new StringBuilder();
		add(sb, merchantId);
		add(sb, origPayId);
		add(sb, orderNo);
		add(sb, dttm);
		add(sb, payMethod);
		add(sb, clientIp);
		add(sb, totalAmount);
		add(sb, currency);
		add(sb, closePayment);
		add(sb, returnUrl);
		add(sb, returnMethod);
		if (null != customer) add(sb, customer.toSign());
		if (null != order) add(sb, order.toSign());
		add(sb, clientInitiated);
		add(sb, sdkUsed);
		add(sb, merchantData);
		add(sb, ttlSec);
		deleteLast(sb);
		return sb.toString();
	}
}
