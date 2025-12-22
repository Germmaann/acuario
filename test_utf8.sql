SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

DELETE af FROM aquarium_fish af JOIN fish_wiki fw ON af.fish_id = fw.id WHERE fw.author_id = 2;
DELETE FROM fish_wiki WHERE author_id = 2;

INSERT INTO fish_wiki (common_name, scientific_name, family, origin, size_min, size_max, temperature_min, temperature_max, ph_min, ph_max, hardness_min, hardness_max, behavior, compatibility, difficulty, feeding, lifespan, description, status, author_id) VALUES
('Guppy', 'Poecilia reticulata', 'Poeciliidae', 'Trinidad y Tobago', 3, 6, 22, 26, 6.8, 7.8, 4, 8, 'Muy activo y pacífico', 'Compatible con la mayoría de peces pequeños', 'muy_fácil', 'Omnívoro: copos, pequeños crustáceos', 2, 'El guppy es uno de los peces más coloridos y populares para acuarios comunitarios principiantes.', 'aprobado', 2),
('Pez Betta', 'Betta splendens', 'Osphronemidae', 'Tailandia', 5, 8, 24, 27, 6, 8, 4, 18, 'Agresivo con otros machos', 'Los machos deben estar solos', 'fácil', 'Carnívoro: insectos pequeños, dáfnias', 3, 'Famoso por sus aletas largas y colores vibrantes.', 'aprobado', 2),
('Tetra Neón', 'Paracheirodon innesi', 'Characidae', 'Sudamérica', 2, 3, 20, 24, 6, 6.5, 4, 8, 'Muy pacífico', 'Excelente con otros tetras', 'fácil', 'Omnívoro: copos pequeños, dáfnias, mosquito pequeño', 5, 'Pequeño pez brillante con línea azul distintiva.', 'aprobado', 2);