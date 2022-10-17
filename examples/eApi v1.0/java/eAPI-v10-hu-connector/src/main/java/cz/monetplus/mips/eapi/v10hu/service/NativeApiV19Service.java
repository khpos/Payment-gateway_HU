package cz.monetplus.mips.eapi.v10hu.service;


import cz.monetplus.mips.eapi.v10hu.connector.entity.*;
import cz.monetplus.mips.eapi.v10hu.connector.entity.responses.*;
import lombok.NonNull;

import java.net.URI;


public interface NativeApiV19Service {


	@NonNull
	PaymentInitResponse paymentInit(@NonNull PaymentInitRequest request) throws MipsException;

	@NonNull
	URI paymentProcess(@NonNull PaymentProcessRequest request) throws MipsException;

	@NonNull
	PaymentStatusResponse paymentStatus(@NonNull PaymentStatusRequest payId) throws MipsException;

	@NonNull
	PaymentResponse paymentClose(@NonNull PaymentCloseRequest request) throws MipsException;

	@NonNull
	PaymentResponse paymentReverse(@NonNull PaymentReverseRequest request) throws MipsException;

	@NonNull
	PaymentResponse paymentRefund(@NonNull PaymentRefundRequest request) throws MipsException;


	@NonNull
	EchoResponse echoGet(@NonNull EchoRequest request) throws MipsException;

	@NonNull
	EchoResponse echoPost(@NonNull EchoRequest request) throws MipsException;


	@NonNull
	OneclickEchoResponse oneclickEcho(@NonNull OneclickEchoRequest request) throws MipsException;

	@NonNull
	OneclickInitResponse oneclickInit(@NonNull OneclickInitRequest request) throws MipsException;

	@NonNull
	OneclickProcessResponse oneclickProcess(@NonNull OneclickProcessRequest request) throws MipsException;


	@NonNull
	ApplepayEchoResponse applepayEcho(@NonNull ApplepayEchoRequest request) throws MipsException;

	@NonNull
	ApplepayInitResponse applepayInit(@NonNull ApplepayInitRequest request) throws MipsException;

	@NonNull
	ApplepayProcessResponse applepayProcess(@NonNull ApplepayProcessRequest request) throws MipsException;


	@NonNull
	GooglepayEchoResponse googlepayEcho(@NonNull GooglepayEchoRequest request) throws MipsException;

	@NonNull
	GooglepayInitResponse googlepayInit(@NonNull GooglepayInitRequest request) throws MipsException;

	@NonNull
	GooglepayProcessResponse googlepayProcess(@NonNull GooglepayProcessRequest request) throws MipsException;
}
