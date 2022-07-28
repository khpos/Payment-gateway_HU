package cz.monetplus.mips.eapi.v10hu.connector.entity.responses;

import cz.monetplus.mips.eapi.v10hu.connector.entity.SignBase;


public class EchoCustomerResponse extends SignBase {
    public String customerId;
    public Long resultCode;
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
