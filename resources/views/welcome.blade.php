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

        /* Add to existing styles */
        .learning-card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .learning-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .modal-header {
            border-radius: 10px 10px 0 0;
        }

        .content-section {
            padding: 1rem;
        }

        .content-section h6 {
            color: #2193b0;
            font-weight: 600;
        }

        .content-section ul li {
            padding: 0.5rem;
            border-radius: 8px;
            background: #f8f9fa;
            margin-bottom: 0.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .btn-outline-primary, .btn-outline-success, .btn-outline-danger {
            border-width: 2px;
            font-weight: 500;
            text-transform: none;
            letter-spacing: normal;
        }

        .btn-outline-primary:hover, .btn-outline-success:hover, .btn-outline-danger:hover {
            transform: translateY(-2px);
        }

        /* Add to existing styles */
        footer {
            margin-top: 5rem;
            box-shadow: 0 -4px 8px rgba(0,0,0,0.1);
        }

        footer a:hover {
            color: #fff !important;
        }

        .tutorial-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .tutorial-icon:hover {
            transform: scale(1.1);
        }

        .stats-badge {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin: 0.25rem;
            display: inline-block;
        }

        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            z-index: 999;
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

        <!-- Materials Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3 class="h5 mb-0">Learning Materials</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Steganography Theory -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 learning-card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-book-open text-primary me-2"></i>
                                            Steganography Theory
                                        </h5>
                                        <p class="card-text">Learn about the fundamentals of steganography and its importance in information security.</p>
                                        <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#theoryModal">
                                            <i class="fas fa-arrow-right me-1"></i> Read More
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- LSB Method -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 learning-card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-microchip text-success me-2"></i>
                                            LSB Method
                                        </h5>
                                        <p class="card-text">Understanding the Least Significant Bit method and its implementation.</p>
                                        <a href="#" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#lsbModal">
                                            <i class="fas fa-arrow-right me-1"></i> Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- GAN Method -->
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 learning-card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <i class="fas fa-brain text-danger me-2"></i>
                                            GAN Method
                                        </h5>
                                        <p class="card-text">Exploring Generative Adversarial Networks in steganography applications.</p>
                                        <a href="#" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ganModal">
                                            <i class="fas fa-arrow-right me-1"></i> Discover
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add after Materials Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h3 class="h5 mb-0">How to Use</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center mb-4">
                                    <i class="fas fa-upload fa-3x text-primary mb-3"></i>
                                    <h5>1. Upload Image</h5>
                                    <p class="text-muted">Select any JPEG or PNG image as your cover medium.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mb-4">
                                    <i class="fas fa-pen fa-3x text-success mb-3"></i>
                                    <h5>2. Enter Message</h5>
                                    <p class="text-muted">Type your secret message and choose encoding method.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mb-4">
                                    <i class="fas fa-download fa-3x text-danger mb-3"></i>
                                    <h5>3. Download Result</h5>
                                    <p class="text-muted">Get your stego image with hidden message.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <div class="modal fade" id="theoryModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Steganography Theory</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="content-section">
                            <h6 class="mb-3">What is Steganography?</h6>
                            <p>Steganography is the practice of concealing information within other non-secret data or carriers, such as images, without revealing its existence.</p>
                            
                            <h6 class="mb-3 mt-4">Key Concepts:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Cover Medium: The carrier of the hidden message</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Payload: The message to be hidden</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Stego Object: The result after embedding</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LSB Modal -->
        <div class="modal fade" id="lsbModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">LSB (Least Significant Bit) Method</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="content-section">
                            <h6 class="mb-3">What is LSB Steganography?</h6>
                            <p>LSB (Least Significant Bit) steganography is a technique of hiding information by modifying the least significant bit of each pixel in an image.</p>

                            <h6 class="mb-3 mt-4">How It Works:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>Pixel Modification:</strong> Changes the last bit of each color channel (R,G,B)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>Binary Conversion:</strong> Converts message to binary before embedding
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <strong>Minimal Impact:</strong> Changes are nearly imperceptible to human eye
                                </li>
                            </ul>

                            <h6 class="mb-3 mt-4">Advantages:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i>Simple implementation</li>
                                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i>Fast processing</li>
                                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i>Low computational cost</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i>Limited capacity</li>
                                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i>Less secure than modern methods</li>
                                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i>Vulnerable to statistical analysis</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GAN Modal -->
        <div class="modal fade" id="ganModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">GAN (Generative Adversarial Network) Method</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="content-section">
                            <h6 class="mb-3">What is GAN Steganography?</h6>
                            <p>GAN-based steganography uses deep learning to hide information in images while maintaining high visual quality and security.</p>

                            <h6 class="mb-3 mt-4">Components:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-robot text-primary me-2"></i>
                                    <strong>Generator:</strong> Creates stego images from cover images and messages
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-search text-warning me-2"></i>
                                    <strong>Discriminator:</strong> Tries to detect hidden messages
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-brain text-danger me-2"></i>
                                    <strong>Neural Networks:</strong> Learn optimal hiding patterns
                                </li>
                            </ul>

                            <h6 class="mb-3 mt-4">Key Features:</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-success">Advantages:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i>High visual quality</li>
                                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i>Better security</li>
                                        <li class="mb-2"><i class="fas fa-plus-circle text-success me-2"></i>Resistant to steganalysis</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-danger">Limitations:</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i>Computationally intensive</li>
                                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i>Requires GPU for efficiency</li>
                                        <li class="mb-2"><i class="fas fa-minus-circle text-danger me-2"></i>Complex implementation</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note:</strong> GAN steganography represents the state-of-the-art in image steganography, offering superior security and quality compared to traditional methods.
                            </div>
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

    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-shield-alt me-2"></i>GreenChiper</h5>
                    <p class="text-muted">Secure steganography solution for your data hiding needs.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none" data-bs-toggle="modal" data-bs-target="#theoryModal">Steganography Theory</a></li>
                        <li><a href="#" class="text-muted text-decoration-none" data-bs-toggle="modal" data-bs-target="#lsbModal">LSB Method</a></li>
                        <li><a href="#" class="text-muted text-decoration-none" data-bs-toggle="modal" data-bs-target="#ganModal">GAN Method</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Statistics</h5>
                    <ul class="list-unstyled">
                        <li class="text-muted"><i class="fas fa-image me-2"></i>Images Processed: {{ $stats->images_count ?? 0 }}</li>
                        <li class="text-muted"><i class="fas fa-clock me-2"></i>Last Activity: {{ $stats->last_activity ?? 'No activity' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

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
                        ${result.data.psnr_value || result.data.ssim_value ? `
                            <div class="mt-3">
                                <span class="badge bg-info metrics-badge">PSNR: ${Number(result.data.psnr_value).toFixed(2)}</span>
                                <span class="badge bg-success metrics-badge">SSIM: ${Number(result.data.ssim_value).toFixed(3)}</span>
                            </div>
                        ` : ''}
                    ` : ''}
                </div>
            `;
        }

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

        // Add to your existing script section
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        window.onscroll = function() {
            const scrollBtn = document.querySelector('.scroll-to-top');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollBtn.style.display = 'block';
            } else {
                scrollBtn.style.display = 'none';
            }
        };
    </script>
    <button class="btn btn-primary rounded-circle scroll-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>
</body>
</html>