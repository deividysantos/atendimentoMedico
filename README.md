# Atendimento Médico

#### Um médico dono de uma clínica que atende pacientes na região de viçosa gostaria de ter um controle maior de seus atendimentos. Para isso ele solicitou que seja criado um pequeno sistema onde ele, os demais médicos e TALVEZ um(a) secretário(a) consiga cadastrar, ver, editar e excluir seus atendimentos.

### O escopo dos dados do sistema foi definido como a seguir:

#### ----------doctor---------- 
    id id
    string name
    string documentMedical_id
    string email
    hash password


#### ----------patient---------- 
    id id
    string name 
    string email
    string phoneNumber
    string document_id
    hash password


#### ----------attendance---------- 
    int id
    id doctor_id 
    id patient_id 
    date entryDate
    date exitDate
    string description

## End Points

### Registros
#### Registro de médicx
#### Registro de pacientx
#### Registro de atendimento por médicx

----------------

### Login
#### Login de médicx
#### Login de pacientx

----------------

### Buscas
#### Busca de atendimentos por médicx
#### Busca de atendimentos por pacientx
