package com.CENIGRAF.GestorMateriales.ServiceCRUD;

import com.CENIGRAF.GestorMateriales.ModelBD.personalCenigrafModel;
import com.CENIGRAF.GestorMateriales.Repository.personalCenigrafRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class personalCenigrafService {

    @Autowired
    private com.CENIGRAF.GestorMateriales.Repository.personalCenigrafRepository personalCenigrafRepository;

    public List<personalCenigrafModel> getAll(){
        return personalCenigrafRepository.getAll();
    }

    public Optional<personalCenigrafModel> getPersonalCenigrafModel(int id){
        return personalCenigrafRepository.getPersonalCenigrafModel(id);
    }
    //Guardar
    public personalCenigrafModel save(personalCenigrafModel personalCenigrafModel){
        if (personalCenigrafModel.getIdPer()==null){
            return personalCenigrafRepository.save(personalCenigrafModel);
        }else{
            Optional<personalCenigrafModel> insaux= personalCenigrafRepository.getPersonalCenigrafModel(personalCenigrafModel.getIdPer());
            if (insaux.isEmpty()){
                return personalCenigrafRepository.save(personalCenigrafModel);
            }else{
                return personalCenigrafModel;
            }
        }
    }

    //Actualizar
    public personalCenigrafModel update(personalCenigrafModel personalCenigrafModel){
        if (personalCenigrafModel.getIdPer() != null){
            Optional<personalCenigrafModel> In= personalCenigrafRepository.getPersonalCenigrafModel(personalCenigrafModel.getIdPer());
            if (!In.isEmpty()){
                if (personalCenigrafModel.getIdPer()!= null){
                    In.get().setIdPer(personalCenigrafModel.getIdPer());
                }
                if (personalCenigrafModel.getNombrePersonal()!=null){
                    In.get().setNombrePersonal(personalCenigrafModel.getNombrePersonal());
                }
                if (personalCenigrafModel.getDocumento()!= null){
                    In.get().setDocumento(personalCenigrafModel.getDocumento());
                }
                if (personalCenigrafModel.getCargo()!= null){
                    In.get().setCargo(personalCenigrafModel.getCargo());
                }

                personalCenigrafRepository.save(In.get());
                return In.get();
            }else {
                return personalCenigrafModel;
            }
        }else {
            return personalCenigrafModel;
        }
    }

    //Borrar
    public boolean deletePersonalCenigrafModel(int id){
        Boolean dIn=getPersonalCenigrafModel(id).map(personaCenigrafModel -> {
            personalCenigrafRepository.delete(personaCenigrafModel);
            return true;
        }).orElse(false);
        return dIn;
    }
}
