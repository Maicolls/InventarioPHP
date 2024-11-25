package com.CENIGRAF.GestorMateriales.ModelBD;

import javax.persistence.*;

@Entity
public class ElementoSolicitado {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;
    private Float cantidad, contador;
    private String nombre, codigo, unidadMedida, observacion;
    @ManyToOne
    @JoinColumn
    private Reporte reporte;

    //otras tablas relacionadas---

    public ElementoSolicitado(Float cantidad, Float contador, String nombre, String codigo, String unidadMedida, String observacion, Reporte reporte) {
        this.cantidad = cantidad;
        this.contador = contador;
        this.nombre = nombre;
        this.codigo = codigo;
        this.unidadMedida = unidadMedida;
        this.observacion = observacion;
        this.reporte = reporte;
    }

    public ElementoSolicitado() {
    }

    public Float getTotal() {
        return this.cantidad ++;
    }

    public Reporte getVenta() {
        return reporte;
    }

    public void setVenta(Reporte venta) {
        this.reporte = venta;
    }

    public Float getContador() {
        return contador;
    }

    public void setcontador(Float contador) {
        this.contador = contador;
    }

    public Float getCantidad() {
        return cantidad;
    }

    public void setCantidad(Float cantidad) {
        this.cantidad = cantidad;
    }

    public String getNombre() {
        return nombre;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public String getCodigo() {
        return codigo;
    }

    public void setCodigo(String codigo) {
        this.codigo = codigo;
    }

    public String getUnidadMedida() {
        return unidadMedida;
    }

    public void setUnidadMedida(String unidadMedida) {
        this.unidadMedida = unidadMedida;
    }

    public String getObservacion() {
        return observacion;
    }

    public void setObservacion(String observacion) {
        this.observacion = observacion;
    }

    public Reporte getReporte() {
        return reporte;
    }

    public void setReporte(Reporte reporte) {
        this.reporte = reporte;
    }
}
