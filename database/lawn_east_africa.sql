-- Create database
CREATE DATABASE IF NOT EXISTS lawn_east_africa;
USE lawn_east_africa;

-- Create tables
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    client VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(50) NOT NULL,
    image VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS partners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data for services
INSERT INTO services (title, description, image, category) VALUES
('Building & Civil Works', 'Construction & Civil Works, Topographical Surveys, Maintenance of gravel roads, Construction and maintenance of drainage structures, Construction of Road Bridges, Construction of other roads structures, Construction and maintenance of paved roads', 'building_civil.jpg', 'construction'),
('Water Systems & Sewerage', 'Water Supply, Reticulation and Dams, Trenching, pipe laying, construction of dams and water pans, greenhouses, water storage tanks, irrigation schemes infrastructure, borehole drilling and equipping, pump houses, water treatment plants and earth dams.', 'water_sewerage.jpg', 'water'),
('Telecommunication', 'Site Acquisition, Survey, Planning and Design, Civil Works and Fiber Installation, Splicing, Testing and Commissioning/Activation, Optical Fiber Network Maintenance, WIMAX Deployment', 'telecom.jpg', 'telecom');

-- Insert sample data for projects
INSERT INTO projects (title, client, description, status, image) VALUES
('Construction of Dairy Plant', 'Ravine Dairies Limited', 'Construction of Dairy Plant at Kabarnet Farm, Nakuru County', 'Completed', 'dairy_plant.jpg'),
('Fibre Optic Construction', 'Vicom Networks Limited', 'Transport Services to Various Site across the country, Supply of fibre optic construction Materials', 'Ongoing', 'fiber_optic.jpg'),
('Construction of Tuition Block', 'Kiota School, Nairobi', 'Construction of Tuition Block at Karen Campus. We were the Main Contractor for this 32 classroom Tuition Block at Kiota School, Karen Campus', 'Completed and in Use', 'tuition_block.jpg'),
('SGR Project', 'China Communications Construction Company Limited', 'Labour Works for Slope Protection and Drainage Works on the Nairobi-Naivasha SGR Project- Sections 1, 3 and 5', 'Completed', 'sgr_project.jpg');

-- Insert sample data for partners
INSERT INTO partners (name, logo) VALUES
('Geonet Technologies Ltd', 'geonet.png'),
('Brent Networks Ltd', 'brent.png'),
('Ravine Dairies Limited', 'ravine.png'),
('China Communications Construction Company Limited', 'cccc.png'),
('Impressio Construzioni Maltauro (ICM)', 'icm.png'),
('Bomet County', 'bomet.png'),
('Kiota School', 'kiota.png');
