package com.CENIGRAF.GestorMateriales.ModelBD;

public class ElementoParaSolicitar extends ElementoConsumible {
    private Float cantidadSolicitada;

    public ElementoParaSolicitar(String descripcionBien, String codigoSena, String unidadMedida, String observacion, Float precio, Float existencia, Integer id, Float cantidadSolicitada) {
        super(descripcionBien, codigoSena, unidadMedida,observacion, precio, existencia, id);
        this.cantidadSolicitada = cantidadSolicitada;
    }

    public ElementoParaSolicitar(String descripcionBien, String codigoSena, String unidadMedida , String observacion, Float precio, Float existencia, Float cantidadSolicitada) {
        super(descripcionBien, codigoSena,unidadMedida, observacion, precio, existencia);
        this.cantidadSolicitada = cantidadSolicitada;
    }

    public void aumentarCantidad() {
        this.cantidadSolicitada++;
    }

    public Float getCantidad() {
        return cantidadSolicitada;
    }

    //total de un solo elemento en la solicitud
    public Float getTotal() {
        return this.cantidadSolicitada * this.getContador();
    }
}
