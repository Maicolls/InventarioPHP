package com.CENIGRAF.GestorMateriales.Repository;

import com.CENIGRAF.GestorMateriales.ModelBD.AmbienteModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.AmbienteCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class AmbienteRepository {

    @Autowired
    private AmbienteCrudRepository ambienteCrudRepository;

    public List<AmbienteModel> getAll(){
        return (List<AmbienteModel>) ambienteCrudRepository.findAll();
    }

    public Optional<AmbienteModel> getAmbienteModel(int id){
        return ambienteCrudRepository.findById(id);
    }

    public  AmbienteModel save(AmbienteModel ambienteModel){
        return ambienteCrudRepository.save(ambienteModel);
    }

    public void delete(AmbienteModel ambienteModel){
        ambienteCrudRepository.delete(ambienteModel);
    }

}
