export default {
    methods: {
        print(element) {
            const printContents = element.innerHTML;
            const printWindow = window.open("", "_blank");
            printWindow.document.open();
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print</title>
                    <link rel="stylesheet" href="/theme/css/bootstrap-extended.css">
                    <link rel="stylesheet" href="/theme/css/bootstrap.min.css">
                    <link rel="stylesheet" href="/theme/css/media-grid.css">
                </head>
                <body>
                    ${printContents}
                </body>
                </html>
            `);
            const script = printWindow.document.createElement("script");
            script.textContent = `
                window.onload = function() {
                window.print();
                window.onafterprint = function() {
                    window.close();
                };
                };
            `;
            printWindow.document.head.appendChild(script);
            printWindow.document.close();
        },
    },
};
