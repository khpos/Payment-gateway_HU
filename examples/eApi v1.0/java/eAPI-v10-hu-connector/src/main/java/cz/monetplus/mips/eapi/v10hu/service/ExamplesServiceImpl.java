package cz.monetplus.mips.eapi.v10hu.service;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import cz.monetplus.mips.eapi.v10hu.connector.entity.*;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.*;
import lombok.NonNull;
import lombok.extern.slf4j.Slf4j;
import org.apache.commons.io.FileUtils;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Service;

import java.io.File;
import java.net.URI;

@Service
@Slf4j
public class ExamplesServiceImpl implements ExamplesService {

    @Value("${merchant.id}")
    private String merchantId;
    private final NativeApiV19Service nativeApiV19Service;

    public ExamplesServiceImpl(NativeApiV19Service nativeApiV19Service) {
        this.nativeApiV19Service = nativeApiV19Service;
    }

    @Override
    public @NonNull PaymentInitResponse paymentInit(@NonNull File initFile) throws MipsException {
        PaymentInitRequest req;
        try {
            Gson gson = new GsonBuilder().create();
            req = gson.fromJson(FileUtils.readFileToString(initFile, "UTF-8"),
                    PaymentInitRequest.class);
        } catch (Exception e) {
            log.error(null, e);
            throw new MipsException(RespCode.INTERNAL_ERROR, "Unable to deserialize init file");
        }
        req.setMerchantId(merchantId);
        return nativeApiV19Service.paymentInit(req);
    }

    @Override
    public @NonNull PaymentStatusResponse paymentStatus(@NonNull String payId) throws MipsException {
        PaymentStatusRequest request = new PaymentStatusRequest(merchantId, payId);
        return nativeApiV19Service.paymentStatus(request);
    }

    @Override
    public @NonNull EchoResponse echoGet() throws MipsException {
        return nativeApiV19Service.echoGet(new EchoRequest(merchantId));
    }

    @Override
    public @NonNull EchoResponse echoPost() throws MipsException {
        return nativeApiV19Service.echoPost(new EchoRequest(merchantId));
    }

    @Override
    public @NonNull URI paymentProcess(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.paymentProcess(new PaymentProcessRequest(merchantId, payId));
    }

    @Override
    public @NonNull PaymentResponse paymentClose(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.paymentClose(new PaymentCloseRequest(merchantId, payId));
    }

    @Override
    public @NonNull PaymentResponse paymentReverse(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.paymentReverse(new PaymentReverseRequest(merchantId, payId));
    }

    @Override
    public @NonNull PaymentResponse paymentRefund(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.paymentRefund(new PaymentRefundRequest(merchantId, payId));
    }

    @Override
    public @NonNull OneclickEchoResponse oneclickEcho(@NonNull String origPayId) throws MipsException {
        return nativeApiV19Service.oneclickEcho(new OneclickEchoRequest(merchantId, origPayId));
    }

    @Override
    public @NonNull OneclickInitResponse oneclickInit(@NonNull File initFile) throws MipsException {
        OneclickInitRequest request;
        try {
            Gson gson = new GsonBuilder().create();
            request = gson.fromJson(FileUtils.readFileToString(initFile, "UTF-8"),
                    OneclickInitRequest.class);
        } catch (Exception e) {
            log.error(null, e);
            throw new MipsException(RespCode.INTERNAL_ERROR, "Unable to deserialize init file");
        }
        request.setMerchantId(merchantId);
        return nativeApiV19Service.oneclickInit(request);
    }

    @Override
    public @NonNull OneclickProcessResponse oneclickProcess(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.oneclickProcess(new OneclickProcessRequest(merchantId, payId));
    }

    @Override
    public @NonNull ApplepayEchoResponse applepayEcho() throws MipsException {
        return nativeApiV19Service.applepayEcho(new ApplepayEchoRequest(merchantId));
    }

    @Override
    public @NonNull GooglepayEchoResponse googlepayEcho() throws MipsException {
        return nativeApiV19Service.googlepayEcho(new GooglepayEchoRequest(merchantId));
    }

    @Override
    public @NonNull ApplepayInitResponse applepayInit(@NonNull File initFile, String payload) throws MipsException {
        ApplepayInitRequest req;
        try {
            Gson gson = new GsonBuilder().create();
            req = gson.fromJson(FileUtils.readFileToString(initFile, "UTF-8"),
                    ApplepayInitRequest.class);
        } catch (Exception e) {
            log.error(null, e);
            throw new MipsException(RespCode.INTERNAL_ERROR, "Unable to deserialize init file");
        }
        req.setMerchantId(merchantId);
        if(null != payload) req.setPayload(payload);
        return nativeApiV19Service.applepayInit(req);
    }

    @Override
    public @NonNull GooglepayInitResponse googlepayInit(@NonNull File initFile, String payload) throws MipsException {
        GooglepayInitRequest req;
        try {
            Gson gson = new GsonBuilder().create();
            req = gson.fromJson(FileUtils.readFileToString(initFile, "UTF-8"),
                    GooglepayInitRequest.class);
        } catch (Exception e) {
            log.error(null, e);
            throw new MipsException(RespCode.INTERNAL_ERROR, "Unable to deserialize init file");
        }
        req.setMerchantId(merchantId);
        if(null != payload) req.setPayload(payload);
        return nativeApiV19Service.googlepayInit(req);
    }

    @Override
    public @NonNull ApplepayProcessResponse applepayProcess(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.applepayProcess(new ApplepayProcessRequest(merchantId, payId));
    }

    @Override
    public @NonNull GooglepayProcessResponse googlepayProcess(@NonNull String payId) throws MipsException {
        return nativeApiV19Service.googlepayProcess(new GooglepayProcessRequest(merchantId, payId));
    }

    @Override
    public @NonNull EchoCustomerResponse echoCustomer(@NonNull String customerId) throws MipsException {
        return nativeApiV19Service.echoCustomer(new EchoCustomerRequest(merchantId, customerId));
    }
}
