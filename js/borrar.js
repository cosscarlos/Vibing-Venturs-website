const {PDFDocument} = require('pdf-lib')

const {readFile, writeFile} = require('fs/promises')

async function createPdf(input, output){

        try{
            const pdfDoc= await PDFDocument.load(await readFile(input))

            console.log(pdfDoc)
        }catch(error){
            console.log(error)
        }
    
}

createPdf(Documentos/form.pdf, "result.pdf")