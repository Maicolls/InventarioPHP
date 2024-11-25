package com.CENIGRAF.GestorMateriales.ServiceCRUD;

import com.CENIGRAF.GestorMateriales.ModelBD.ProgramaModel;
import com.CENIGRAF.GestorMateriales.Repository.ProgramaRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class ProgramaService {

    @Autowired
    ProgramaRepository programaRepository;

    public List<ProgramaModel>getAll(){
        return programaRepository.getAll();
    }

    public Optional<ProgramaModel>getProgramaModel(int id){
        return programaRepository.getProgramaModel(id);
    }

    public ProgramaModel save(ProgramaModel programaModel){
        if (programaModel.getIdPrograma()==null){
            return programaRepository.save(programaModel);
        }else{
            Optional<ProgramaModel> proaux=programaRepository.getProgramaModel(programaModel.getIdPrograma());
            if (proaux.isEmpty()){
                return programaRepository.save(programaModel);
            }else{
                return programaModel;
            }
        }
    }

    public ProgramaModel update(ProgramaModel programaModel){
        if (programaModel.getIdPrograma()!=null){
            Optional<ProgramaModel> Pr=programaRepository.getProgramaModel(programaModel.getIdPrograma());
            if (!Pr.isEmpty()){
                if (programaModel.getIdPrograma()!=null){
                    Pr.get().setIdPrograma(programaModel.getIdPrograma());
                }
                if (programaModel.getNombrePrograma()!=null){
                    Pr.get().setNombrePrograma(programaModel.getNombrePrograma());
                }
                programaRepository.save(Pr.get());
                return Pr.get();
            }else{
                return programaModel;
            }
        }else{
            return programaModel;
        }
    }

    public boolean deleteProgramaModel(int id){
        Boolean dPr=getProgramaModel(id).map(programaModel -> {
            programaRepository.delete(programaModel);
            return true;
        }).orElse(false);
        return dPr;
    }


}
