import axios from "@/axios-config";
export function downloadCSV(filenamePrefix,apiUrl) 
{
    axios.get(apiUrl)
    .then(response => {
        const currentDate = new Date().toISOString().slice(0, 10);
        const filename = `${filenamePrefix}_${currentDate}.csv`;
      
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
    })
    .catch(error => {
        console.error(error);
    });
    
}
  