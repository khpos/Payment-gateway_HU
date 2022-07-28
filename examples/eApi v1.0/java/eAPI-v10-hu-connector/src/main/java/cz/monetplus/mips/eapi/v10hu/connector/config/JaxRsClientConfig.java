package cz.monetplus.mips.eapi.v10hu.connector.config;

import java.util.ArrayList;
import java.util.List;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;

import cz.monetplus.mips.eapi.v10hu.connector.INativeAPIv10HuResource;

import com.fasterxml.jackson.jaxrs.json.JacksonJaxbJsonProvider;

/**
 * JAX RS client configuration
 *
 */
@Configuration
public class JaxRsClientConfig {

	@Value("${native.api.url}")
	private String url;

	@Value("${native.api.ssl:true}")
	private boolean ssl;
	
	@Value("${native.api.trust.all.certs:true}")
	private boolean trustAllCerts;
	
	@Value("${native.api.truststore:}")
	private String trustStore;
	
	@Value("${native.api.truststore.password:}")
	private String trustStorePassword;
	
	@Value("${native.api.connect.timeout.ms:10000}")
	private int connectTimeout;

	@Value("${native.api.receive.timeout.ms:10000}")
	private int receiveTimeout;

	@Bean
	public JacksonJaxbJsonProvider jacksonJaxbJsonProvider() {
		return new JacksonJaxbJsonProvider();
	}

	@Bean
	public INativeAPIv10HuResource getNativeAPIv1ResourceRestClient() {
		return new JaxRsClientStarter<INativeAPIv10HuResource>().start(INativeAPIv10HuResource.class, url, ssl,
				trustAllCerts, trustStore, trustStorePassword, 
				getProviders(), connectTimeout, receiveTimeout);
	}

	@SuppressWarnings({ "unchecked", "rawtypes" })
	protected List<?> getProviders() {
		List providers = new ArrayList();
		providers.add(jacksonJaxbJsonProvider());
		return providers;
	}

}