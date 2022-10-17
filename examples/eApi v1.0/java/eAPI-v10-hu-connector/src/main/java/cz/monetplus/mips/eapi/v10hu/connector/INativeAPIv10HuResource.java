package cz.monetplus.mips.eapi.v10hu.connector;

import javax.ws.rs.Consumes;
import javax.ws.rs.GET;
import javax.ws.rs.POST;
import javax.ws.rs.PUT;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;
import javax.ws.rs.core.Response;

import cz.monetplus.mips.eapi.v10hu.connector.entity.ApplepayEchoRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.ApplepayInitRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.ApplepayProcessRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.EchoRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.GooglepayEchoRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.GooglepayInitRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.GooglepayProcessRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.OneclickEchoRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.OneclickInitRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.OneclickProcessRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.PaymentCloseRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.PaymentInitRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.PaymentRefundRequest;
import cz.monetplus.mips.eapi.v10hu.connector.entity.PaymentReverseRequest;


@Path( "/api/v1.0" )
public interface INativeAPIv10HuResource {

	@Path("/payment/init")
    @Produces(MediaType.APPLICATION_JSON)
    @Consumes(MediaType.APPLICATION_JSON)
    @POST
    Response paymentInit(PaymentInitRequest req);

	@GET
	@Path( "/payment/status/{merchantId}/{payId}/{dttm}/{signature}" ) 
	@Produces(MediaType.APPLICATION_JSON)
	Response paymentStatus(@PathParam("merchantId") String merchantId, 
			@PathParam("payId") String payId, 
			@PathParam("dttm") String dttm, 
			@PathParam("signature") String signature); 

	@PUT
	@Path( "/payment/reverse" ) 
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response paymentReverse(PaymentReverseRequest req); 

	@GET
	@Path("/payment/process/{merchantId}/{payId}/{dttm}/{signature}")
	@Produces(MediaType.TEXT_HTML)
	Response paymentProcess(@PathParam("merchantId") String merchantId,
	@PathParam("payId") String payId, 
	@PathParam("dttm") String dttm, 
	@PathParam("signature") String signature);

	@PUT
	@Path( "/payment/close" ) 
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response paymentClose(PaymentCloseRequest req);
	
	@PUT
	@Path( "/payment/refund" ) 
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response paymentRefund(PaymentRefundRequest req);


	@Path( "/oneclick/echo" )
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	@POST
	Response oneclickEcho(OneclickEchoRequest req);

	@Path( "/oneclick/init" ) 
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	@POST
	Response oneclickInit(OneclickInitRequest req);

	@Path( "/oneclick/process" )
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	@POST
	Response oneclickProcess(OneclickProcessRequest req);

	
	@GET
	@Path( "/echo/{merchantId}/{dttm}/{signature}" ) 
	@Produces(MediaType.APPLICATION_JSON)
	Response echo(@PathParam("merchantId") String merchantId, 
			@PathParam("dttm") String dttm, 
			@PathParam("signature") String signature);
	
	@POST
	@Path( "/echo" ) 
	@Produces(MediaType.APPLICATION_JSON)
	@Consumes(MediaType.APPLICATION_JSON)
	Response echo(EchoRequest req);


	@POST
	@Path( "/googlepay/init" ) 
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response googlepayInit(GooglepayInitRequest req);

	@POST
	@Path("/googlepay/echo")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response googlepayEcho(GooglepayEchoRequest req);

	@POST
	@Path( "/googlepay/process" )
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response googlepayProcess(GooglepayProcessRequest req);


	@POST
	@Path("/applepay/echo")
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response applepayEcho(ApplepayEchoRequest req);
	
	@POST
	@Path( "/applepay/init" ) 
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response applepayInit(ApplepayInitRequest req);

	@POST
	@Path( "/applepay/process" )
	@Consumes(MediaType.APPLICATION_JSON)
	@Produces(MediaType.APPLICATION_JSON)
	Response applepayProcess(ApplepayProcessRequest request);
}
