package com.CENIGRAF.GestorMateriales.Repository;

import com.CENIGRAF.GestorMateriales.ModelBD.TransaccionalRepoModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.TransaccionalRepoCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class TransaccionalRepoRepository {

    @Autowired
    private TransaccionalRepoCrudRepository transaccionalRepoCrudRepository;

    public List<TransaccionalRepoModel> getAll(){
        return (List<TransaccionalRepoModel>) transaccionalRepoCrudRepository.findAll();
    }

    public Optional<TransaccionalRepoModel> getTransaccionalRepoModel(int id){
        return transaccionalRepoCrudRepository.findById(id);
    }

    public TransaccionalRepoModel save(TransaccionalRepoModel transaccionalRepoModel){
        return transaccionalRepoCrudRepository.save(transaccionalRepoModel);
    }

    public void delete(TransaccionalRepoModel transaccionalRepoModel){
        transaccionalRepoCrudRepository.delete(transaccionalRepoModel);
    }

}
