package com.CENIGRAF.GestorMateriales.ModelBD;



import javax.persistence.*;
import java.io.Serializable;

@Entity
@Table(name = "personal_cenigraf")
public class personalCenigrafModel implements Serializable {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)

    private Integer idPer;
    private String nombrePersonal;
    private Integer documento;
    private String cargo;

    @ManyToOne
    @JoinColumn
    private Reporte reporte;

    public Integer getIdPer() {
        return idPer;
    }

    public void setIdPer(Integer idPer) {
        this.idPer = idPer;
    }

    public String getNombrePersonal() {
        return nombrePersonal;
    }

    public void setNombrePersonal(String nombrePersonal) {
        this.nombrePersonal = nombrePersonal;
    }

    public Integer getDocumento() {
        return documento;
    }

    public void setDocumento(Integer documento) {
        this.documento = documento;
    }

    public String getCargo() {
        return cargo;
    }

    public void setCargo(String cargo) {
        this.cargo = cargo;
    }


    private static final long serialVersionUID = 1L;
}
