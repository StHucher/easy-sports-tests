const app = {
    init:function()
    {
    //    const select = document.getElementById('teamSelect');
    //    select.addEventListener('change',app.handleChange);
       const form = document.getElementById('form-team');
       form.addEventListener('submit',app.handleSubmit);
       const formPlayer = document.getElementById('form-player');
       formPlayer.addEventListener('submit',app.handleSubmitPlayer);

    },

    // handleChange:function(evt)
    // {   
    //     console.log('dans le if');
    //     const form = document.getElementById('form-team');
    //     form.submit();
    // },

    handleSubmit:function(evt)
    {   
        console.log('submit');
        // const form = document.getElementById('form-team');
        // const post = form.value;
        // console.log(post);
        // evt.preventDefault();
    },

    handleSubmitPlayer:function(evt)
    {
        console.log('submit');
        // evt.preventDefault();
    }


}

app.init();