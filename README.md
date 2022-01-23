# Atendimento Médico

#### Um médico dono de uma clínica que atende pacientes na região de viçosa gostaria de ter um controle maior de seus atendimentos. Para isso ele solicitou que seja criado um pequeno sistema onde ele, os demais médicos e TALVEZ um(a) secretário(a) consiga cadastrar, ver, editar e excluir seus atendimentos.

Um escopo dos dados do sistema foi definido como a seguir:

### ----------doctor---------- 
    uuid id
    string name
    string documentMedical_id
    hash password


### ----------patient---------- 
    uuid id
    string name 
    string phoneNumber
    string document_id


### ----------medicalCare---------- 
    int id
    uuid doctor_id 
    uuid patient_id 
    date entryDate
    date exitDate
    string description
