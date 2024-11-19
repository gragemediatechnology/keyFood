
    function openProfile(){
        document.getElementById('dropdown').style.display = 'none';
        document.getElementById('profileCard').style.display = 'flex';
        document.getElementById('home').style.display = 'none';
    }

    function hideProfile() {
        const screenWidth = window.innerWidth;
        const dropdown = document.getElementById('dropdown');
        const profileCard = document.getElementById('profileCard');
        document.getElementById('dropdown').style.display = 'flex';
        document.getElementById('home').style.display = 'block';
        document.getElementById('profileCard').style.display = 'none';
      }


   
    

