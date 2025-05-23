import sys
import json
import numpy as np
from PIL import Image
from skimage.metrics import structural_similarity as ssim

def calculate_metrics(original_img, stego_img):
    """Calculate PSNR and SSIM between two images"""
    try:
        # Convert images to numpy arrays with float32 type and normalize to [0, 1]
        orig_array = np.array(original_img, dtype=np.float32) / 255.0
        stego_array = np.array(stego_img, dtype=np.float32) / 255.0
        
        # Calculate MSE and PSNR
        mse = np.mean((orig_array - stego_array) ** 2)
        if mse == 0:
            psnr = 100
        else:
            psnr = 20 * np.log10(1.0 / np.sqrt(mse))
        
        # Calculate SSIM for RGB image
        ssim_value = ssim(
            orig_array,
            stego_array,
            data_range=1.0,
            channel_axis=2,  # Specify RGB channel axis
            multichannel=True
        )
        
        return psnr, float(ssim_value)
    
    except Exception as e:
        print(f"Error calculating metrics: {str(e)}")
        return 0, 0

def encode_lsb(image_path, message, output_path):
    try:
        # Load the image
        img = Image.open(image_path).convert('RGB')
        original_img = img.copy()
        pixels = np.array(img)
        width, height = img.size

        # Convert message to binary + terminator
        binary_message = ''.join(format(ord(c), '08b') for c in message)
        binary_message += '11111111' + '00000000'  # Add terminator

        if len(binary_message) > width * height * 3:
            return json.dumps({
                'success': False,
                'error': 'Message too long for image capacity'
            })

        # Embed message
        msg_index = 0
        modified = False
        
        for y in range(height):
            for x in range(width):
                if msg_index < len(binary_message):
                    pixel = pixels[y, x].copy()
                    for i in range(3):  # R,G,B channels
                        if msg_index < len(binary_message):
                            pixel[i] = (pixel[i] & 0xFE) | int(binary_message[msg_index])
                            msg_index += 1
                            modified = True
                    pixels[y, x] = pixel
                else:
                    break

        if not modified:
            return json.dumps({
                'success': False,
                'error': 'Failed to embed message'
            })

        # Save stego image
        stego_img = Image.fromarray(pixels)
        stego_img.save(output_path, 'PNG')

        # Calculate metrics
        psnr, ssim_value = calculate_metrics(original_img, stego_img)

        return json.dumps({
            'success': True,
            'message': 'Image encoded successfully',
            'psnr': float(psnr),
            'ssim': float(ssim_value)
        })

    except Exception as e:
        return json.dumps({
            'success': False,
            'error': str(e)
        })

def decode_lsb(image_path):
    try:
        # Load the stego image
        img = Image.open(image_path).convert('RGB')
        pixels = np.array(img)
        width, height = img.size

        # Extract binary message
        binary_message = ''
        terminator = '11111111' + '00000000'  # FF00 terminator
        
        for y in range(height):
            for x in range(width):
                pixel = pixels[y, x]
                # Get LSB from each RGB channel
                for color in pixel:
                    binary_message += str(color & 1)
                
                # Look for terminator sequence
                if len(binary_message) >= len(terminator):
                    term_index = binary_message.find(terminator)
                    if term_index != -1:
                        # Extract message before terminator
                        binary_message = binary_message[:term_index]
                        
                        # Convert binary to text in 8-bit chunks
                        message = ''
                        for i in range(0, len(binary_message), 8):
                            if i + 8 <= len(binary_message):
                                byte = binary_message[i:i+8]
                                try:
                                    char = chr(int(byte, 2))
                                    if 32 <= ord(char) <= 126:  # Printable ASCII range
                                        message += char
                                except ValueError:
                                    continue
                        
                        if message:  # Only return if we found a valid message
                            return json.dumps({
                                'success': True,
                                'message': message.strip()
                            })

        return json.dumps({
            'success': False,
            'error': 'No hidden message found'
        })

    except Exception as e:
        return json.dumps({
            'success': False,
            'error': f'Decoding failed: {str(e)}'
        })

if __name__ == '__main__':
    if len(sys.argv) < 2:
        print(json.dumps({
            'success': False,
            'error': 'No command specified'
        }))
        sys.exit(1)

    command = sys.argv[1]

    if command == 'encode':
        if len(sys.argv) != 5:
            print(json.dumps({
                'success': False,
                'error': 'Invalid arguments for encode. Usage: script.py encode input_image message output_path'
            }))
            sys.exit(1)
        print(encode_lsb(sys.argv[2], sys.argv[3], sys.argv[4]))

    elif command == 'decode':
        if len(sys.argv) != 3:
            print(json.dumps({
                'success': False,
                'error': 'Invalid arguments for decode. Usage: script.py decode image_path'
            }))
            sys.exit(1)
        print(decode_lsb(sys.argv[2]))

    else:
        print(json.dumps({
            'success': False,
            'error': f'Unknown command: {command}'
        }))
        sys.exit(1)