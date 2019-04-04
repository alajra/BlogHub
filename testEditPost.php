<!DOCTYPE html>

<html>

<head>

<title>Text-editor</title>
<script src="https://cdn.quilljs.com/1.1.3/quill.js"></script>
<script src="https://cdn.quilljs.com/1.1.3/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.quilljs.com/1.1.3/quill.snow.css">
<link rel="stylesheet" type="text/css" href="https://cdn.quilljs.com/1.1.3/quill.bubble.css">

</head>

<body>

  <div id="toolbar">
  </div>
  <div id="editor">
  </div>

  <script type="text/javascript">

        var toolbarOptions= [
      ['bold', 'italic', 'underline', 'strike','blockquote', 'code-block'],
      [{'header' :[1 ,2 ,3 ,4 ,5 ,6 ,false] }],
      [{'list' :'ordered'}, {'list' :'bullet'}],
      [{'script' :'sub'}, {'script' :'super'}],
      [{'indent' :'-1'}, {'indent' :'+1'}],
      [{'direction' :'rtl'}],
      [{'size' : ['small', false, 'large', 'huge'] }],
      ['link', 'image' ,'video', 'formula'],
      [{'color' :[] }, {'background' :[] }],
      [{'font' : [] }],
      [{'align' : []} ]
      ];

      var quill =new Quill('#editor', {
      modules: {
      toolbar: toolbarOptions
      },

      theme: 'snow'

    });

    </script>

</body>

</html>
