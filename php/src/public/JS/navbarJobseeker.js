const btnEL = document.querySelector('.btn-search');
const inputEL = document.querySelector('.form-control');

btnEL.addEventListener('click', (e) => {
    let searchValue = inputEL.value;


    if(searchValue !== '') {
        let searchCategory = jobvacancyData.filter(function(data){
            if(data.posisi.toLowerCase().includes(searchValue.toLowerCase())){
                return data;
            }
            else if(data.jenisJob.includes(searchValue)){
                return data;

            }
        })
        if(searchCategory){
            generateJobVacancyCards(searchCategory);
            generatePagination(searchCategory);
        }


        inputEL.value = '';
    }else{
        alert("Please search the job position !");
    }
});