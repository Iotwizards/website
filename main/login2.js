function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        // console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);

        // Pass the token to your server.
        // This example assumes you have a form on your page that posts to your server.
        // You'll need to add an additional input field to your form for the ID token.
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '/your-server-side-code'); // Update this value to your server-side script

        var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'idtoken');
        input.setAttribute('value', id_token);

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
      }