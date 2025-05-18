<!DOCTYPE html>
<html>
<head>
    <title>GreenChiper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system;
        }

        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            padding: 1rem 1.5rem;
        }

        .card-header.bg-primary {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%) !important;
        }

        .card-header.bg-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        }

        .card-header.bg-dark {
            background: linear-gradient(135deg, #434343 0%, #000000 100%) !important;
        }

        .preview-image {
            max-width: 300px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .preview-image:hover {
            transform: scale(1.05);
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #dee2e6;
            padding: 0.75rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.1);
        }

        .btn {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
        }

        .metrics-badge {
            font-size: 0.9em;
            margin: 0 5px;
            padding: 0.5em 1em;
            border-radius: 20px;
        }

        .method-info {
            font-size: 0.85em;
            margin-top: 0.5rem;
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #2193b0;
        }

        .progress {
            height: 0.8rem;
            border-radius: 1rem;
        }

        .table {
            background: white;
            border-radius: 15px;
        }

        .table th {
            border-top: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .img-thumbnail {
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
        }

        #decodedMessage pre {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            border-left: 4px solid #38ef7d;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .btn-download {
            transition: all 0.3s ease;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .btn-download {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            border: none;
            padding: 1rem 2rem;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px rgba(33, 147, 176, 0.2);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(33, 147, 176, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-download:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(33, 147, 176, 0.2);
        }

        .preview-image {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border-radius: 8px;
        }

        .preview-image:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .btn-download {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 4px 6px rgba(33, 147, 176, 0.2);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(33, 147, 176, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-download:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(33, 147, 176, 0.2);
        }

        .metrics-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="loading-overlay">
        <div class="loading-spinner"></div>
    </div>

    <nav class="navbar navbar-dark">
        <div class="container">
            <span class="navbar-brand">
                <i class="fas fa-shield-alt me-2"></i>
                GreenChiper
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Encode Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h5 mb-0">Encode Message</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('steganography.encode') }}" method="POST" enctype="multipart/form-data" id="encodeForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Cover Image:</label>
                                <input type="file" name="image" class="form-control" required accept="image/*" onchange="previewImage(this, 'coverPreview')">
                                <img id="coverPreview" class="preview-image d-none">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Secret Message:</label>
                                <textarea name="message" class="form-control" required rows="3"></textarea>
                                <small class="text-muted">Maximum message length depends on image size</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Steganography Method:</label>
                                <select name="method" class="form-control" required>
                                    <option value="gan">GAN (Best Quality)</option>
                                    <option value="autoencoder">Autoencoder (Fast)</option>
                                    <option value="lsb">LSB (Basic)</option>
                                </select>
                                <div class="method-info text-muted"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <span class="spinner-border spinner-border-sm loading d-none" role="status"></span>
                                <span>Encode Image</span>
                            </button>
                            <div class="progress-wrapper">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" 
                                         aria-valuenow="100" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100" 
                                         style="width: 100%">
                                        Processing...
                                    </div>
                                </div>
                            </div>
                            <div class="error-message"></div>
                        </form>
                    </div>
                </div>
                <!-- Ini di luar card -->
                <div id="encodeResult" class="mt-3"></div>
            </div>

            <!-- Decode Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3 class="h5 mb-0">Decode Message</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('steganography.decode') }}" method="POST" enctype="multipart/form-data" id="decodeForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Stego Image:</label>
                                <input type="file" name="image" class="form-control" required accept="image/*" onchange="previewImage(this, 'stegoPreview')">
                                <img id="stegoPreview" class="preview-image d-none">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Steganography Method:</label>
                                <select name="method" class="form-control" required>
                                    <option value="gan">GAN</option>
                                    <option value="autoencoder">Autoencoder</option>
                                    <option value="lsb">LSB</option>
                                </select>
                                <div class="method-info text-muted"></div>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <span class="spinner-border spinner-border-sm loading d-none" role="status"></span>
                                <span>Decode Message</span>
                            </button>
                            <div class="progress-wrapper">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" 
                                         aria-valuenow="100" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100" 
                                         style="width: 100%">
                                        Processing...
                                    </div>
                                </div>
                            </div>
                            <div class="error-message"></div>
                        </form>

                        <div id="decodedMessage" class="mt-3 d-none">
                            <h6>Decoded Message:</h6>
                            <pre class="bg-light p-2 rounded"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Table -->
        <div class="card mt-4">
            <div class="card-header bg-dark text-white">
                <h3 class="h5 mb-0">Previous Results</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Original Image</th>
                                <th>Stego Image</th>
                                <th>Method</th>
                                <th>Metrics</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($images as $image)
                            <tr>
                                <td><img src="{{ asset('storage/' . $image->original_image) }}" class="img-thumbnail" width="100"></td>
                                <td><img src="{{ asset('storage/' . $image->stego_image) }}" class="img-thumbnail" width="100"></td>
                                <td>
                                    <span class="badge bg-primary">{{ $image->method_used }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info metrics-badge">PSNR: {{ number_format($image->psnr_value, 2) }}</span>
                                    <span class="badge bg-success metrics-badge">SSIM: {{ number_format($image->ssim_value, 2) }}</span>
                                </td>
                                <td>{{ $image->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Enhanced form handling
        document.querySelectorAll('form').forEach(form => {
            // Hide progress bars and spinners initially
            const progressWrapper = form.querySelector('.progress-wrapper');
            const loadingSpinner = form.querySelector('.loading');
            if (progressWrapper) progressWrapper.style.display = 'none';
            if (loadingSpinner) loadingSpinner.classList.add('d-none');

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const loadingOverlay = document.querySelector('.loading-overlay');
                const submitButton = this.querySelector('button[type="submit"]');
                const loadingSpinner = this.querySelector('.loading');
                const progressWrapper = this.querySelector('.progress-wrapper');
                const errorMessage = this.querySelector('.error-message');
                
                try {
                    // Show loading states
                    loadingOverlay.style.display = 'flex';
                    submitButton.disabled = true;
                    loadingSpinner.classList.remove('d-none');
                    progressWrapper.style.display = 'block';
                    errorMessage.textContent = '';

                    const formData = new FormData(this);
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const result = await response.json();
                    
                    if (this.id === 'decodeForm' && result.message) {
                        const decodedMessage = document.getElementById('decodedMessage');
                        decodedMessage.querySelector('pre').textContent = result.message;
                        decodedMessage.classList.remove('d-none');
                    } else if (this.id === 'encodeForm' && result.success) {
                        handleEncodeSuccess(result);
                    } else {
                        throw new Error(result.message || 'An error occurred');
                    }
                } catch (error) {
                    errorMessage.textContent = error.message;
                    errorMessage.classList.add('alert', 'alert-danger', 'mt-3');
                } finally {
                    // Hide loading states
                    loadingOverlay.style.display = 'none';
                    submitButton.disabled = false;
                    loadingSpinner.classList.add('d-none');
                    progressWrapper.style.display = 'none';
                }
            });
        });

        function handleEncodeSuccess(result) {
            const resultDiv = document.getElementById('encodeResult');
            resultDiv.innerHTML = `
                <div class="alert alert-success mb-3">
                    <i class="fas fa-check-circle me-2"></i>${result.message}
                </div>
                <div class="d-flex flex-column align-items-center">
                    ${result.data && result.data.stego_image ? `
                        <div class="text-center mb-3">
                            <h6 class="mb-2">Preview:</h6>
                            <img src="/storage/${result.data.stego_image}" 
                                class="img-thumbnail preview-image mb-3" 
                                style="max-width: 300px; cursor: pointer"
                                onclick="window.open('/storage/${result.data.stego_image}', '_blank')"
                                alt="Encoded image">
                            <div class="mt-2">
                                <a href="${result.download_url}" class="btn btn-primary btn-lg btn-download" download>
                                    <i class="fas fa-download me-2"></i>Download Encoded Image
                                </a>
                            </div>
                        </div>
                        ${result.data.psnr_value ? `
                            <div class="mt-3">
                                <span class="badge bg-info metrics-badge">PSNR: ${result.data.psnr_value.toFixed(2)}</span>
                                <span class="badge bg-success metrics-badge">SSIM: ${result.data.ssim_value.toFixed(2)}</span>
                            </div>
                        ` : ''}
                    ` : ''}
                </div>
            `;
        }

        // Add animation to method info display
        document.querySelectorAll('select[name="method"]').forEach(select => {
            select.addEventListener('change', function() {
                const info = {
                    'gan': '<i class="fas fa-star me-2"></i>Best quality, slower processing. Recommended for important images.',
                    'autoencoder': '<i class="fas fa-balance-scale me-2"></i>Good balance of quality and speed.',
                    'lsb': '<i class="fas fa-bolt me-2"></i>Fast but basic. Limited payload capacity.'
                };
                
                const infoDiv = this.parentElement.querySelector('.method-info');
                infoDiv.innerHTML = info[this.value];
                infoDiv.style.opacity = '0';
                setTimeout(() => infoDiv.style.opacity = '1', 100);
            });

            // Trigger change event on load
            select.dispatchEvent(new Event('change'));
        });

        document.getElementById('encodeForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = form.querySelector('button[type="submit"]');
            const spinner = submitBtn.querySelector('.loading');
            const resultDiv = document.getElementById('encodeResult');
            
            try {
                submitBtn.disabled = true;
                spinner.classList.remove('d-none');
                resultDiv.innerHTML = '';
                
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    resultDiv.innerHTML = `
                        <div class="alert alert-success mb-3">
                            <i class="fas fa-check-circle me-2"></i>${result.message}
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            ${result.data && result.data.stego_image ? `
                                <div class="text-center mb-3">
                                    <h6 class="mb-2">Preview:</h6>
                                    <img src="/storage/${result.data.stego_image}" 
                                        class="img-thumbnail preview-image mb-3" 
                                        style="max-width: 300px; cursor: pointer"
                                        onclick="window.open('/storage/${result.data.stego_image}', '_blank')"
                                        alt="Encoded image">
                                    <div class="mt-2">
                                        <a href="${result.download_url}" class="btn btn-primary btn-lg btn-download" download>
                                            <i class="fas fa-download me-2"></i>Download Encoded Image
                                        </a>
                                    </div>
                                </div>
                            ` : ''}
                            ${result.data && result.data.psnr_value ? `
                                <div class="mt-3">
                                    <span class="badge bg-info metrics-badge">PSNR: ${result.data.psnr_value.toFixed(2)}</span>
                                    <span class="badge bg-success metrics-badge">SSIM: ${result.data.ssim_value.toFixed(2)}</span>
                                </div>
                            ` : ''}
                        </div>
                    `;
                } else {
                    throw new Error(result.message);
                }
            } catch (error) {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>${error.message}
                    </div>
                `;
            } finally {
                submitBtn.disabled = false;
                spinner.classList.add('d-none');
            }
        });

        // Add this to make sure download buttons work with preview
        document.addEventListener('click', function(e) {
            if (e.target && e.target.closest('.btn-download')) {
                const downloadBtn = e.target.closest('.btn-download');
                const originalText = downloadBtn.innerHTML;
                
                downloadBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Downloading...
                `;
                
                setTimeout(() => {
                    downloadBtn.innerHTML = originalText;
                }, 1000);
            }
        });
    </script>
</body>
</html>