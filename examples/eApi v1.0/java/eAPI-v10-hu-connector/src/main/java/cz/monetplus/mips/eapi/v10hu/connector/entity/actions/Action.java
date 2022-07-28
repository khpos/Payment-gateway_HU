package cz.monetplus.mips.eapi.v10hu.connector.entity.actions;

import com.fasterxml.jackson.databind.annotation.JsonDeserialize;
import cz.monetplus.mips.eapi.v10hu.connector.ActionDeserializer;
import cz.monetplus.mips.eapi.v10hu.connector.entity.SignBase;

@JsonDeserialize(using = ActionDeserializer.class)
public abstract class Action extends SignBase {
    
}
