import { add } from "@hotwired/stimulus";

const test = {
    init:function()
    {
        const selectTest = document.getElementById('result_current_user_test');
        selectTest.addEventListener('change',test.handleChangeTest)
    },

    handleChangeTest:function(evt)
    {   
        const nameTest = document.querySelector('.name_test')
        const imgTest = document.getElementById('test_img')
        const videoTest = document.getElementById('test_video')
        const descriptionTest = document.getElementById('description_test')
        const selectedValue = document.getElementById('result_current_user_test').value;
        let fetchOptions = {
            method: 'GET',
            mode:   'cors',
            cache:  'no-cache'
        };
        fetch('http://localhost:8080/testFromResult/' + selectedValue, fetchOptions)
            .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            return Promise.reject(response);
        }).then(function (data) {
            console.log(data);
            for(let d in data){
                nameTest.textContent = 'Test : '+data[d].name+' (en '+ data[d].unit+')'
                descriptionTest.textContent = data[d].description
                videoTest.src = ''
                imgTest.src=''
                if(!videoTest.classList.contains('d-none')){
                    videoTest.classList.add('d-none');
                }
                if(data[d].media != null){
                    if(data[d].media.endsWith('mp4')){
                        videoTest.classList.remove('d-none')
                        videoTest.src = data[d].media
                    }else{
                        imgTest.src = '../uploads/images/tests/' + data[d].media
                    }
                    
                }
                
            }
            
            
            
            
        }).catch(function (error) {
            console.log("le message d'erreur", error);
        });
    }
}

test.init();
