package cz.monetplus.mips.eapi.v10hu.service;

import java.io.File;
import java.net.URI;

import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.*;
import lombok.NonNull;

public interface ExamplesService {
    @NonNull EchoResponse echoPost() throws MipsException;
    @NonNull EchoResponse echoGet() throws MipsException;

    @NonNull PaymentInitResponse paymentInit(@NonNull File initFile) throws MipsException;
    @NonNull PaymentStatusResponse paymentStatus(@NonNull String payId) throws MipsException;
    @NonNull URI paymentProcess(@NonNull String payId) throws MipsException;

    @NonNull PaymentResponse paymentClose(@NonNull String payId) throws MipsException;
    @NonNull PaymentResponse paymentReverse(@NonNull String payId) throws MipsException;
    @NonNull PaymentResponse paymentRefund(@NonNull String payId) throws MipsException;

    @NonNull OneclickEchoResponse oneclickEcho(@NonNull String origPayId) throws MipsException;
    @NonNull OneclickInitResponse oneclickInit(@NonNull File initFile) throws MipsException;
    @NonNull OneclickProcessResponse oneclickProcess(@NonNull String payId) throws MipsException;

    @NonNull ApplepayEchoResponse applepayEcho() throws MipsException;
    @NonNull ApplepayInitResponse applepayInit(@NonNull File initFile, String payload) throws MipsException;
    @NonNull ApplepayProcessResponse applepayProcess(@NonNull String PayId) throws MipsException;

    @NonNull GooglepayEchoResponse googlepayEcho() throws MipsException;
    @NonNull GooglepayInitResponse googlepayInit(@NonNull File initFile, String payload) throws MipsException;
    @NonNull GooglepayProcessResponse googlepayProcess(@NonNull String payId) throws MipsException;
}
