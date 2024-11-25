package com.CENIGRAF.GestorMateriales.ServiceCRUD;

import com.CENIGRAF.GestorMateriales.ModelBD.FichaModel;
import com.CENIGRAF.GestorMateriales.Repository.FichaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class FichaService {

    @Autowired
    FichaRepository fichaRepository;

    public List<FichaModel>getAll(){
        return fichaRepository.getAll();
    }

    public Optional<FichaModel>getFichaModel(int id){
        return fichaRepository.getFichaModel(id);
    }

    public  FichaModel save(FichaModel fichaModel){
        if (fichaModel.getIdFicha()==null){
            return fichaRepository.save(fichaModel);
        }else{
            Optional<FichaModel>ficaux=fichaRepository.getFichaModel(fichaModel.getIdFicha());
            if (ficaux.isEmpty()){
                return fichaRepository.save(fichaModel);
            }else {
                return fichaModel;
            }
        }
    }

    public FichaModel update(FichaModel fichaModel){
        if (fichaModel.getIdFicha()!=null){
            Optional<FichaModel> Fi=fichaRepository.getFichaModel(fichaModel.getIdFicha());
            if (!Fi.isEmpty()){
                if (fichaModel.getIdFicha()!=null){
                    Fi.get().setIdFicha(fichaModel.getIdFicha());
                }
                if (fichaModel.getNumeroFicha()!=null){
                    Fi.get().setNumeroFicha(fichaModel.getNumeroFicha());
                }
                fichaRepository.save(Fi.get());
                return Fi.get();
            }else {
                return fichaModel;
            }
        }else{
            return fichaModel;
        }
    }

    public boolean deleteFichaModel(int id){
        Boolean dFi=getFichaModel(id).map(fichaModel -> {
            fichaRepository.delete(fichaModel);
            return true;
        }).orElse(false);
        return dFi;
    }

}
