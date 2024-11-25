package com.CENIGRAF.GestorMateriales.Repository;

import com.CENIGRAF.GestorMateriales.ModelBD.FichaModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.FichaCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class FichaRepository {

    @Autowired
    private FichaCrudRepository fichaCrudRepository;

    public List<FichaModel>getAll(){
        return (List<FichaModel>) fichaCrudRepository.findAll();
    }

    public Optional<FichaModel>getFichaModel(int id){
        return fichaCrudRepository.findById(id);
    }

    public FichaModel save(FichaModel fichaModel){
        return fichaCrudRepository.save(fichaModel);
    }

    public void delete(FichaModel fichaModel){
        fichaCrudRepository.delete(fichaModel);
    }

}
