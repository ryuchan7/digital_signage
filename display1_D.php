<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display 1_1</title>
    <style>
        body {
            margin: 0;
            overflow: hidden; /* Prevent scrolling */
        }
        #pdf-container {
            width: 100%;
            height: 100vh; /* Full height of the viewport */
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f0f0f0; /* Light background for better visibility */
        }
        canvas {
            width: auto; /* Auto width to maintain aspect ratio */
            height: 100%; /* Full height of the container */
            max-height: 100%; /* Prevent overflow */
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
</head>

<body onload="onload();">
    <div id="pdf-container">
        <canvas id="pdf-canvas"></canvas>
    </div>

    <script>
        const document_list = [];
        let document_index = 0;
        let pdfDoc = null;
        let currentPage = 1;
        const canvas = document.getElementById('pdf-canvas');
        const ctx = canvas.getContext('2d');
        const pageDelay = 10000; // Time in milliseconds to display each page

        function onload() {
            fetchDocumentList(); // Fetch the documents on load
        }

        function fetchDocumentList() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_document_list1.php', true); // Path to the PHP script that retrieves document list
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document_list.push(...JSON.parse(xhr.responseText)); // Populate the document list
                    if (document_list.length > 0) {
                        loadDocument(document_list[document_index]); // Load the first document
                    }
                } else {
                    console.error("Failed to fetch document list");
                }
            };
            xhr.send();
        }

        function loadDocument(documentPath) {
            pdfjsLib.getDocument(documentPath).promise.then(function(pdf) {
                pdfDoc = pdf;
                currentPage = 1; // Reset to the first page
                renderPage(currentPage); // Render the first page
            });
        }

        function renderPage(pageNumber) {
            pdfDoc.getPage(pageNumber).then(function(page) {
                const viewport = page.getViewport({ scale: 1 });
                const scale = calculateScale(viewport.width, viewport.height); // Calculate best fit scale
                const scaledViewport = page.getViewport({ scale });

                canvas.width = scaledViewport.width;
                canvas.height = scaledViewport.height;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: scaledViewport
                };
                page.render(renderContext).promise.then(function() {
                    // Go to the next page after the specified delay
                    setTimeout(() => {
                        currentPage++;
                        if (currentPage > pdfDoc.numPages) {
                            currentPage = 1; // Loop back to the first page
                            document_index = (document_index + 1) % document_list.length; // Move to the next document
                            loadDocument(document_list[document_index]); // Load the next document
                        } else {
                            renderPage(currentPage); // Render the next page
                        }
                    }, pageDelay);
                });
            });
        }

        function calculateScale(originalWidth, originalHeight) {
            const container = document.getElementById('pdf-container');
            const containerWidth = container.clientWidth;
            const containerHeight = container.clientHeight;

            const widthScale = containerWidth / originalWidth;
            const heightScale = containerHeight / originalHeight;

            return Math.min(widthScale, heightScale); // Return the smaller scale to fit the page
        }
    </script>
</body>
</html>
