$( function() {
    let viewProfil = document.getElementById("viewProfil");
    let btnChangeProfil = document.getElementById("btnChangeProfil");
    let editProfil = document.getElementById("editProfil");
    let notChangeProfile = document.getElementById("notChangeProfile");

    btnChangeProfil.onclick = function () {
        viewProfil.style.display = "none";
        editProfil.style.display = "block";
    }

    notChangeProfile.onclick = function () {
        viewProfil.style.display = "block";
        editProfil.style.display = "none";
    }

    let validation = true;
    $('#updateProfilForm').submit(function(e){
        e.preventDefault();
        let lName = "";
        let fName = "";
        //console.log(e);
        if ($('#fName').val().length == 0) {
            alert('le prénom est obligatoire')
            validation = false;
        }
        else{
            fName = $('#fName').val();
        }

        if ($('#lName').val().length == 0) {
            alert('le nom est obligatoire')
            validation = false;
        }
        else{
            lName = $('#lName').val();
        }
        let gender = $('#gender option:selected').val();
        let birthday = $('#birthday').val();
        let location = $('#location option:selected').val();
        let job = $('#job').val();
        let shareProfile = $('#sahreProfile').prop("checked");
        let data = 
        {
            "firstName": escape(fName), 
            "lastName": escape(lName), 
            "gender": gender,
             "birthday": birthday, 
             "location": location, 
             "job": job, 
             "shareProfile": shareProfile
        };
        //validation = true;
        // Ajax for updating
        if (validation) {
            
            $.ajax({
                url: '/profile',
                type: 'POST',
                data: {
                    'data': data
                },
                success: function (data,status) {
                    console.log(data);
                    console.log(status);
                    if (data == '1') {
                        window.location.reload();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });

        }

    });
});