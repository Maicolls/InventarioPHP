package com.CENIGRAF.GestorMateriales.ModelBD;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.validation.constraints.Min;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;

@Entity
public class ElementoConsumible {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @NotNull(message = "Debes especificar el nombre")
    @Size(min = 1, max = 50, message = "El nombre debe medir entre 1 y 50")
    private String descripcionBien;

    @NotNull(message = "Debes especificar el código")
    @Size(min = 1, max = 50, message = "El código debe medir entre 1 y 50")
    private String codigoSena;
    //unidad de medida
    @NotNull(message = "Debes especificar la unidad de medida")
    @Size(min = 1, max = 50, message = "La unidad debe medir entre 1 y 50")
    private String unidadMedida;
    //observaciones
    @NotNull(message = "Debes especificar la observacion")
    @Size(min = 1, max = 50, message = "La unidad debe medir entre 1 y 50")
    private String observacion;
    //PENDIENTE POR BORRAR O CAMBIAR PRECIO
    @NotNull(message = "Debes especificar el precio")
    @Min(value = 0, message = "El precio mínimo es 0")
    private Float contador;

    @NotNull(message = "Debes especificar la existencia")
    @Min(value = 0, message = "La existencia mínima es 0")
    private Float existenciaAlmacen;



    public ElementoConsumible(String descripcionBien, String codigoSena, String unidadMedida , String observacion, Float contador, Float existenciaAlmacen, Integer id) {
        this.descripcionBien = descripcionBien;
        this.codigoSena = codigoSena;
        this.unidadMedida = unidadMedida;
        this.observacion = observacion;
        this.contador = contador;
        this.existenciaAlmacen = existenciaAlmacen;
        this.id = id;
    }

    public ElementoConsumible(String descripcionBien, String codigoSena, String unidadMedida, String observacion, Float contador, Float existenciaAlmacen) {
        this.descripcionBien = descripcionBien;
        this.codigoSena = codigoSena;
        this.unidadMedida = unidadMedida;
        this.observacion = observacion;
        this.contador = contador;
        this.existenciaAlmacen = existenciaAlmacen;
    }

    public ElementoConsumible(@NotNull(message = "Debes especificar el código") @Size(min = 1, max = 50, message = "El código debe medir entre 1 y 50") String codigoSena) {
        this.codigoSena = codigoSena;
    }

    public ElementoConsumible() {
    }

    public boolean sinExistenciaAlmacen() {
        return this.existenciaAlmacen <= 0;
    }

    public String getCodigoSena() {
        return codigoSena;
    }

    public void setCodigoSena(String codigoSena) {
        this.codigoSena = codigoSena;
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

    public Float getContador() {
        return contador = 1f;
    }

    public void setcontador(Float precio) {
        this.contador = contador;
    }

    public Float getExistenciaAlmacen() {
        return existenciaAlmacen;
    }

    public void setExistenciaAlmacen(Float existenciaAlmacen) {
        this.existenciaAlmacen = existenciaAlmacen;
    }

    public void restarExistenciaAlmacen(Float existenciaAlmacen) {
        this.existenciaAlmacen -= existenciaAlmacen;
    }

    public String getDescripcionBien() {
        return descripcionBien;
    }

    public void setDescripcionBien(String descripcionBien) {
        this.descripcionBien = descripcionBien;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }
}
