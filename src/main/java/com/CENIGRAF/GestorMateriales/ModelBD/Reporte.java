package com.CENIGRAF.GestorMateriales.ModelBD;

import javax.persistence.*;
import java.util.Set;

@Entity
public class Reporte {
    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;
    private String fechaYHora;

    //tablas relacionadas---
    @OneToMany(mappedBy = "reporte", cascade = CascadeType.ALL)
    private Set<ElementoSolicitado> productos;

    @OneToMany(mappedBy = "reporte", cascade = CascadeType.ALL)
    private Set<FichaModel> ficha;

    @OneToMany(mappedBy = "reporte", cascade = CascadeType.ALL)
    private Set<personalCenigrafModel> personas;

    //atributos por ingresar

    private String area;
    private String destinoBienes;
    private String nombreCoordinador;
    private String Cuentadante1;
    private String Cuentadante2;
    private String Cuentadante3;
    private String tipoCuentadante;
    private String firma;

    public Reporte() {
        this.fechaYHora = Utiles.obtenerFechaYHoraActual();
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Float getTotal() {
        Float total = 0f;
        for (ElementoSolicitado productoVendido : this.productos) {
            total += productoVendido.getTotal();
        }
        return total;
    }

    public String getFechaYHora() {
        return fechaYHora;
    }

    public void setFechaYHora(String fechaYHora) {
        this.fechaYHora = fechaYHora;
    }

    public Set<ElementoSolicitado> getProductos() {
        return productos;
    }

    public void setProductos(Set<ElementoSolicitado> productos) {
        this.productos = productos;
    }

    public Set<personalCenigrafModel> getPersonas() {
        return personas;
    }

    public void setPersonas(Set<personalCenigrafModel> personas) {
        this.personas = personas;
    }

    public Set<FichaModel> getFicha() {
        return ficha;
    }

    public void setFicha(Set<FichaModel> ficha) {
        this.ficha = ficha;
    }

    public String getArea() {
        return area;
    }

    public void setArea(String area) {
        this.area = area;
    }

    public String getDestinoBienes() {
        return destinoBienes;
    }

    public void setDestinoBienes(String destinoBienes) {
        this.destinoBienes = destinoBienes;
    }

    public String getNombreCoordinador() {
        return nombreCoordinador;
    }

    public void setNombreCoordinador(String nombreCoordinador) {
        this.nombreCoordinador = nombreCoordinador;
    }

    public String getCuentadante1() {
        return Cuentadante1;
    }

    public void setCuentadante1(String cuentadante1) {
        Cuentadante1 = cuentadante1;
    }

    public String getCuentadante2() {
        return Cuentadante2;
    }

    public void setCuentadante2(String cuentadante2) {
        Cuentadante2 = cuentadante2;
    }

    public String getCuentadante3() {
        return Cuentadante3;
    }

    public void setCuentadante3(String cuentadante3) {
        Cuentadante3 = cuentadante3;
    }

    public String getTipoCuentadante() {
        return tipoCuentadante;
    }

    public void setTipoCuentadante(String tipoCuentadante) {
        this.tipoCuentadante = tipoCuentadante;
    }

    public String getFirma() {
        return firma;
    }

    public void setFirma(String firma) {
        this.firma = firma;
    }
}
