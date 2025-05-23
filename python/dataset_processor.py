import os
import sys
import json
import numpy as np
from PIL import Image
from sklearn.model_selection import train_test_split

def process_dataset(input_dir, output_dir, split_ratio=0.8):
    try:
        # Create output directories
        train_dir = os.path.join(output_dir, 'training')
        test_dir = os.path.join(output_dir, 'testing')
        os.makedirs(train_dir, exist_ok=True)
        os.makedirs(test_dir, exist_ok=True)

        # Get all images
        images = []
        for root, _, files in os.walk(input_dir):
            for file in files:
                if file.lower().endswith(('.png', '.jpg', '.jpeg')):
                    images.append(os.path.join(root, file))

        # Split dataset
        train_images, test_images = train_test_split(
            images, 
            train_size=split_ratio, 
            random_state=42
        )

        # Process and save images
        def process_images(image_list, output_dir):
            for img_path in image_list:
                try:
                    img = Image.open(img_path).convert('RGB')
                    # Resize to standard size
                    img = img.resize((256, 256), Image.LANCZOS)
                    # Save with original filename
                    filename = os.path.basename(img_path)
                    save_path = os.path.join(output_dir, filename)
                    img.save(save_path, 'PNG', quality=95)
                except Exception as e:
                    print(f"Error processing {img_path}: {str(e)}")

        process_images(train_images, train_dir)
        process_images(test_images, test_dir)

        stats = {
            'total_images': len(images),
            'training_images': len(train_images),
            'testing_images': len(test_images)
        }

        return json.dumps({
            'success': True,
            'message': 'Dataset processed successfully',
            'stats': stats
        })

    except Exception as e:
        return json.dumps({
            'success': False,
            'error': str(e)
        })

if __name__ == '__main__':
    if len(sys.argv) != 3:
        print(json.dumps({
            'success': False,
            'error': 'Invalid arguments. Usage: script.py input_dir output_dir'
        }))
        sys.exit(1)

    print(process_dataset(sys.argv[1], sys.argv[2]))