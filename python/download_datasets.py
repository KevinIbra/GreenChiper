import requests
import os
import zipfile

def download_boss_dataset():
    url = "http://dde.binghamton.edu/download/ImageDB/BOSSbase_1.01.zip"
    output_dir = "storage/app/public/datasets/boss"
    
    if not os.path.exists(output_dir):
        os.makedirs(output_dir)
    
    # Download file
    response = requests.get(url, stream=True)
    zip_path = os.path.join(output_dir, "boss.zip")
    
    with open(zip_path, "wb") as f:
        for chunk in response.iter_content(chunk_size=8192):
            if chunk:
                f.write(chunk)
    
    # Extract files
    with zipfile.ZipFile(zip_path, 'r') as zip_ref:
        zip_ref.extractall(output_dir)
    
    # Clean up
    os.remove(zip_path)