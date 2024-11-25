package com.CENIGRAF.GestorMateriales.ServiceCRUD;

import com.CENIGRAF.GestorMateriales.ModelBD.TransaccionalRepoModel;
import com.CENIGRAF.GestorMateriales.Repository.TransaccionalRepoRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class TransaccionalRepoService {

    @Autowired
    TransaccionalRepoRepository transaccionalRepoRepository;

    public List<TransaccionalRepoModel> getAll(){
        return transaccionalRepoRepository.getAll();
    }

    public Optional<TransaccionalRepoModel> getTransaccionalRepoModel(int id){
        return transaccionalRepoRepository.getTransaccionalRepoModel(id);
    }

    public TransaccionalRepoModel save(TransaccionalRepoModel transaccionalRepoModel){
        if (transaccionalRepoModel.getIdReporte()==null){
            return transaccionalRepoRepository.save(transaccionalRepoModel);
        }else{
            Optional<TransaccionalRepoModel> transaux=transaccionalRepoRepository.getTransaccionalRepoModel(transaccionalRepoModel.getIdReporte());
            if (transaux.isEmpty()){
                return transaccionalRepoRepository.save(transaccionalRepoModel);
            }else{
                return transaccionalRepoModel;
            }
        }
    }

    public TransaccionalRepoModel update(TransaccionalRepoModel transaccionalRepoModel){
        if (transaccionalRepoModel.getIdReporte()!=null){
            Optional<TransaccionalRepoModel> Tran=transaccionalRepoRepository.getTransaccionalRepoModel(transaccionalRepoModel.getIdReporte());
            if (!Tran.isEmpty()){
                if(transaccionalRepoModel.getIdReporte()!=null){
                    Tran.get().setIdReporte(transaccionalRepoModel.getIdReporte());
                }
                if (transaccionalRepoModel.getFecha()!=null){
                    Tran.get().setFecha(transaccionalRepoModel.getFecha());
                }
                if (transaccionalRepoModel.getPersonalCenigrafModel()!=null){
                    Tran.get().setPersonalCenigrafModel(transaccionalRepoModel.getPersonalCenigrafModel());
                }
                if (transaccionalRepoModel.getAmbienteModel()!=null){
                    Tran.get().setAmbienteModel(transaccionalRepoModel.getAmbienteModel());
                }
                if (transaccionalRepoModel.getMaquinaModel()!=null){
                    Tran.get().setMaquinaModel(transaccionalRepoModel.getMaquinaModel());
                }
                if (transaccionalRepoModel.getObservaciones()!=null){
                    Tran.get().setObservaciones(transaccionalRepoModel.getObservaciones());
                }
                transaccionalRepoRepository.save(Tran.get());
                return Tran.get();
            }else{
                return transaccionalRepoModel;
            }
        }else {
            return transaccionalRepoModel;
        }
    }

    public boolean deleteTransaccionalRepoModel(int id){
        Boolean dTran=getTransaccionalRepoModel(id).map(transaccionalRepoModel -> {
            transaccionalRepoRepository.delete(transaccionalRepoModel);
            return true;
        }).orElse(false);
        return dTran;
    }

}
