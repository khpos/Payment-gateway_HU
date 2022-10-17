package cz.monetplus.mips.eapi.v10hu.service;

import javax.ws.rs.core.Response;

import cz.monetplus.mips.eapi.v10hu.connector.entity.*;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import cz.monetplus.mips.eapi.v10hu.connector.INativeAPIv10HuResource;
import lombok.NonNull;

import java.net.URI;
import java.net.URLEncoder;
import java.nio.charset.StandardCharsets;

@Service
public class NativeApiV19ServiceImpl implements NativeApiV19Service {

    private final INativeAPIv10HuResource resource;

    @Autowired
    public NativeApiV19ServiceImpl(INativeAPIv10HuResource nativeApiResource, CryptoService cryptoService) {
        this.resource = nativeApiResource;
    }

    @Override
    @SignedApiMethod
    public @NonNull PaymentInitResponse paymentInit(@NonNull PaymentInitRequest request) throws MipsException {
        try {
            Response response = resource.paymentInit(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            PaymentInitResponse res = response.readEntity(PaymentInitResponse.class);
            return res;
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull URI paymentProcess(@NonNull PaymentProcessRequest request) throws MipsException {
        try {
            Response response = resource.paymentProcess(request.merchantId, request.payId, request.dttm, URLEncoder.encode(request.signature, StandardCharsets.UTF_8.toString()));
            if (response == null || response.getStatus() != 303) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.getLocation();
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull PaymentStatusResponse paymentStatus(@NonNull PaymentStatusRequest request) throws MipsException {
        try {
            Response response = resource.paymentStatus(request.getMerchantId(),
                    request.getPayId(), request.getDttm(), URLEncoder.encode(request.getSignature(), StandardCharsets.UTF_8.toString()));
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(PaymentStatusResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    /*
    @Override
	public PayRes paymentClose(String payId, Long totalAmount) throws MipsException {
		try {
			PayCloseReq req = new PayCloseReq(merchantId, payId, totalAmount);
			cryptoService.createSignature(req);
			Response response = nativeApiResource.paymentClose(req);
			if (response == null || response.getStatus() != 200) {
				throw new MipsException(RespCode.INTERNAL_ERROR, "No response from nativeAPI for paymentClose operation, http response " + (response != null ? response.getStatus() : "--"));
			}
			PayRes res = response.readEntity(PayRes.class);
			if (!cryptoService.isSignatureValid(res)) {
				throw new MipsException(RespCode.INTERNAL_ERROR, "Invalid signature for response " + res.toJson());
			}
			return res;
		}
		catch (Exception e) {
			throw new MipsException(RespCode.INTERNAL_ERROR, "nativeAPI call for paymentClose operation failed: ", e);
		}
	}
     */

    @Override
    @SignedApiMethod
    public @NonNull PaymentResponse paymentClose(@NonNull PaymentCloseRequest request) throws MipsException {
        try {
            Response response = resource.paymentClose(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR, "No response from nativeAPI, http response " + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(PaymentResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR, "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull PaymentResponse paymentReverse(@NonNull PaymentReverseRequest request) throws MipsException {
        try {
            Response response = resource.paymentReverse(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(PaymentResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull PaymentResponse paymentRefund(@NonNull PaymentRefundRequest request) throws MipsException {
        try {
            Response response = resource.paymentRefund(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(PaymentResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull EchoResponse echoGet(@NonNull EchoRequest request) throws MipsException {
        try {
            Response response = resource.echo(request.merchantId, request.dttm, URLEncoder.encode(request.signature, StandardCharsets.UTF_8.toString()));
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(EchoResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull EchoResponse echoPost(@NonNull EchoRequest request) throws MipsException {
        try {
            Response response = resource.echo(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI  http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(EchoResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull OneclickEchoResponse oneclickEcho(@NonNull OneclickEchoRequest request) throws MipsException {
        try {
            Response response = resource.oneclickEcho(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(OneclickEchoResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull OneclickInitResponse oneclickInit(@NonNull OneclickInitRequest request) throws MipsException {
        try {
            Response response = resource.oneclickInit(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(OneclickInitResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull OneclickProcessResponse oneclickProcess(@NonNull OneclickProcessRequest request) throws MipsException {
        try {
            Response response = resource.oneclickProcess(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(OneclickProcessResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull ApplepayEchoResponse applepayEcho(@NonNull ApplepayEchoRequest request) throws MipsException {
        try {
            Response response = resource.applepayEcho(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(ApplepayEchoResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull GooglepayEchoResponse googlepayEcho(@NonNull GooglepayEchoRequest request) throws MipsException {
        try {
            Response response = resource.googlepayEcho(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(GooglepayEchoResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull ApplepayInitResponse applepayInit(@NonNull ApplepayInitRequest request) throws MipsException {
        try {
            Response response = resource.applepayInit(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(ApplepayInitResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull ApplepayProcessResponse applepayProcess(@NonNull ApplepayProcessRequest request) throws MipsException {
        try {
            Response response = resource.applepayProcess(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(ApplepayProcessResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull GooglepayInitResponse googlepayInit(@NonNull GooglepayInitRequest request) throws MipsException {
        try {
            Response response = resource.googlepayInit(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(GooglepayInitResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

    @Override
    @SignedApiMethod
    public @NonNull GooglepayProcessResponse googlepayProcess(@NonNull GooglepayProcessRequest request) throws MipsException {
        try {
            Response response = resource.googlepayProcess(request);
            if (response == null || response.getStatus() != 200) {
                throw new MipsException(RespCode.INTERNAL_ERROR,
                        "No response from nativeAPI, http response "
                                + (response != null ? response.getStatus() : "--"));
            }
            return response.readEntity(GooglepayProcessResponse.class);
        } catch (Exception e) {
            throw new MipsException(RespCode.INTERNAL_ERROR,
                    "nativeAPI call failed: " + e.getMessage());
        }
    }

}
