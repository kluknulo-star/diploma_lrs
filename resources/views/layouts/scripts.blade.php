<script>
    let buttonsDelete = document.querySelectorAll('.delete-btn');
    buttonsDelete.forEach(buttonsDelete => {
        buttonsDelete.addEventListener('click', (evt) => {
            let result = confirm('Вы уверены?');
            if (!result) {
                evt.preventDefault();
            }
        })
    })

    function myFunction(tokenId) {
        var copyText = document.getElementById("myInput" + tokenId);
        copyText.select();
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
    }
</script>
