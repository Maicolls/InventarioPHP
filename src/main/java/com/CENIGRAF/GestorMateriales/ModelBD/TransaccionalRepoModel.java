package com.CENIGRAF.GestorMateriales.ModelBD;

import javax.persistence.*;
import java.io.Serializable;
import java.util.Date;

@Entity
@Table(name = "Reporte_Maquina")
public class TransaccionalRepoModel implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)

    private Integer idReporte;

    @Temporal(value = TemporalType.DATE)
    private Date fecha;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "idPer")
    private personalCenigrafModel personalCenigrafModel;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "idAmbiente")
    private AmbienteModel ambienteModel;

    @ManyToOne(fetch = FetchType.LAZY)
    @JoinColumn(name = "idMaquina")
    private MaquinaModel maquinaModel;

    //tipo correctivo o preventivo

    private String Observaciones;


    public Integer getIdReporte() {
        return idReporte;
    }

    public void setIdReporte(Integer idReporte) {
        this.idReporte = idReporte;
    }

    public Date getFecha() {
        return fecha;
    }

    public void setFecha(Date fecha) {
        this.fecha = fecha;
    }

    public com.CENIGRAF.GestorMateriales.ModelBD.personalCenigrafModel getPersonalCenigrafModel() {
        return personalCenigrafModel;
    }

    public void setPersonalCenigrafModel(com.CENIGRAF.GestorMateriales.ModelBD.personalCenigrafModel personalCenigrafModel) {
        this.personalCenigrafModel = personalCenigrafModel;
    }

    public AmbienteModel getAmbienteModel() {
        return ambienteModel;
    }

    public void setAmbienteModel(AmbienteModel ambienteModel) {
        this.ambienteModel = ambienteModel;
    }

    public MaquinaModel getMaquinaModel() {
        return maquinaModel;
    }

    public void setMaquinaModel(MaquinaModel maquinaModel) {
        this.maquinaModel = maquinaModel;
    }

    public String getObservaciones() {
        return Observaciones;
    }

    public void setObservaciones(String observaciones) {
        Observaciones = observaciones;
    }

    public void addRepoA(TransaccionalRepoModel transaccionalRepoModel) {
    }
}
