package com.CENIGRAF.GestorMateriales.Repository;


import com.CENIGRAF.GestorMateriales.ModelBD.personalCenigrafModel;
import com.CENIGRAF.GestorMateriales.Repository.CrudRepository.PersonalCenigrafCrudRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.Optional;

@Repository
public class personalCenigrafRepository {

    @Autowired
    private PersonalCenigrafCrudRepository personalCenigrafCrudRepository;

    public List<personalCenigrafModel> getAll(){
        return (List<personalCenigrafModel>) personalCenigrafCrudRepository.findAll();
    }

    public Optional<personalCenigrafModel> getPersonalCenigrafModel(int id){
        return personalCenigrafCrudRepository.findById(id);
    }

    public personalCenigrafModel save(personalCenigrafModel personalCenigrafModel){
        return personalCenigrafCrudRepository.save(personalCenigrafModel);
    }

    public  void delete(personalCenigrafModel personalCenigrafModel){
        personalCenigrafCrudRepository.delete(personalCenigrafModel);
    }

}
