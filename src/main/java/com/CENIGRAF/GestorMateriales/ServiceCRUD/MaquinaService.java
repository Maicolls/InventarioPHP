package com.CENIGRAF.GestorMateriales.ServiceCRUD;

import com.CENIGRAF.GestorMateriales.ModelBD.MaquinaModel;
import com.CENIGRAF.GestorMateriales.Repository.MaquinaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class MaquinaService {

    @Autowired
    MaquinaRepository maquinaRepository;

    public List<MaquinaModel>getAll(){
        return maquinaRepository.getAll();
    }

    public Optional<MaquinaModel> getMaquinaModel(int id){
        return maquinaRepository.getMaquinaModel(id);
    }

    public MaquinaModel save(MaquinaModel maquinaModel){
        if (maquinaModel.getIdMaquina()==null){
            return maquinaRepository.save(maquinaModel);
        }else {
            Optional<MaquinaModel> maqaux=maquinaRepository.getMaquinaModel(maquinaModel.getIdMaquina());
            if (maqaux.isEmpty()){
                return maquinaRepository.save(maquinaModel);
            }else {
                return maquinaModel;
            }
        }
    }

    public MaquinaModel update(MaquinaModel maquinaModel){
        if (maquinaModel.getIdMaquina()!=null){
            Optional<MaquinaModel> Ma=maquinaRepository.getMaquinaModel(maquinaModel.getIdMaquina());
            if (!Ma.isEmpty()){
                if (maquinaModel.getIdMaquina()!=null){
                    Ma.get().setIdMaquina(maquinaModel.getIdMaquina());
                }
                if (maquinaModel.getNombreMaquina()!=null){
                    Ma.get().setNombreMaquina(maquinaModel.getNombreMaquina());
                }
                if (maquinaModel.getPlaca()!=null){
                    Ma.get().setPlaca(maquinaModel.getPlaca());
                }
                if (maquinaModel.getAdquisicion()!=null){
                    Ma.get().setAdquisicion(maquinaModel.getAdquisicion());
                }
                if (maquinaModel.getSerial()!=null){
                    Ma.get().setSerial(maquinaModel.getSerial());
                }
                maquinaRepository.save(Ma.get());
                return Ma.get();
            }else {
                return maquinaModel;
            }
        }else {
            return maquinaModel;
        }
    }


    public boolean deleteMaquinaModel(int id){
        Boolean dMa=getMaquinaModel(id).map(maquinaModel -> {
            maquinaRepository.delete(maquinaModel);
            return true;
        }).orElse(false);
        return dMa;
    }

}
