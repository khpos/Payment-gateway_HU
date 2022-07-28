package cz.monetplus.mips.eapi.v10hu.connector.entity;

import lombok.*;

@EqualsAndHashCode(callSuper = true)
@Data
@RequiredArgsConstructor
public class ApplepayEchoRequest extends SignBase {
    @NonNull
    private String merchantId;

    @Override
    public String toSign() {
        StringBuilder sb = new StringBuilder();
        add(sb, merchantId);
        add(sb, dttm);
        deleteLast(sb);
        return sb.toString();
    }  
}
