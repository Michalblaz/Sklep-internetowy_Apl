--
-- PostgreSQL database dump
--

-- Dumped from database version 17.6
-- Dumped by pg_dump version 17.5

-- Started on 2026-04-23 13:00:27
--
-- TOC entry 3976 (class 0 OID 17539)
-- Dependencies: 389
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4008 (class 0 OID 20314)
-- Dependencies: 421
-- Data for Name: Bans; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3978 (class 0 OID 17552)
-- Dependencies: 391
-- Data for Name: addresses; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4001 (class 0 OID 20110)
-- Dependencies: 414
-- Data for Name: attribute_category; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attribute_category (id, name) VALUES (1, 'socket') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (3, 'cores') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (2, 'cpu_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (4, 'threads') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (5, 'base_clock') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (6, 'boost_clock') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (10, 'graphics_card_series') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (11, 'motherboard_chipset') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (12, 'board_standard') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (13, 'ram_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (14, 'ram_capacity_gb') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (15, 'ram_speed_mhz') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (16, 'ram_latency_cl') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (17, 'storage_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (18, 'storage_capacity_gb') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (19, 'storage_interface') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (20, 'psu_wattage') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (21, 'psu_efficiency_rating') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (22, 'psu_standard') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (23, 'case_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (24, 'max_gpu_length_mm') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (25, 'max_cpu_cooler_height_mm') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (26, 'connectivity_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (27, 'sensor_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (28, 'switch_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (29, 'audio_channels') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (30, 'cooler_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (32, 'network_standard') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (33, 'interface_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (34, 'monitor_resolution') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (35, 'refresh_rate_hz') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (36, 'panel_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (37, 'screen_size_inch') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (7, 'integrated_gpu') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (8, 'connector_type') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (9, 'chipset_manufacturer') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (38, 'fan_included') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (39, 'fan_max_tdp') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (40, 'GPU_length') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (41, 'CPU_cooler_height') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (42, 'cpu_generation') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (43, 'supported_cpu_generations') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (44, 'ram_slots') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (45, 'ram_modules') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (46, 'gpu_power_connectors') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (47, 'cpu_power_connector') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (48, 'm2_slots') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (49, 'radiator_size') ON CONFLICT (name) DO NOTHING;
INSERT INTO public.attribute_category (id, name) VALUES (50, 'max_radiator') ON CONFLICT (name) DO NOTHING;



--
-- TOC entry 4003 (class 0 OID 20120)
-- Dependencies: 416
-- Data for Name: attribute_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (1, 1, 'AM4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (2, 1, 'AM5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (19, 10, 'RTX z serii 30');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (20, 10, 'RTX z serii 40');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (21, 10, 'RTX z serii 50');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (22, 10, 'RX z serii 6');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (23, 10, 'RX z serii 7');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (24, 10, 'RX z serii 9');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (25, 10, 'Intel Arc');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (55, 9, 'NVIDIA');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (56, 9, 'AMD');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (57, 9, 'Intel');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (58, 11, 'B860');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (59, 11, 'B850');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (4, 1, 'LGA 1700');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (3, 1, 'LGA 1200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (5, 1, 'LGA 1851');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (10, 2, 'AMD Ryzen 7');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (11, 2, 'AMD Ryzen 9');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (12, 2, 'Intel Core i3');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (13, 2, 'Intel Core i5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (14, 2, 'Intel Core i7');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (15, 2, 'Intel Core i9');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (16, 2, 'Intel Core Ultra 5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (17, 2, 'Intel Core Ultra 7');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (18, 2, 'Intel Core Ultra 9');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (8, 2, 'AMD Ryzen 3');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (9, 2, 'AMD Ryzen 5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (7, 1, 'sTR5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (6, 1, 'LGA 2066');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (26, 11, 'B450');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (27, 11, 'B550');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (28, 11, 'X570');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (29, 11, 'B650');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (30, 11, 'X670');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (31, 11, 'B760');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (32, 11, 'Z790');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (33, 12, 'ATX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (34, 12, 'm-ATX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (35, 12, 'Mini-ITX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (36, 12, 'E-ATX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (37, 13, 'DDR4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (38, 13, 'DDR5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (39, 17, 'HDD');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (40, 17, 'SSD');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (41, 17, 'M.2 NVMe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (42, 19, 'SATA III');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (43, 19, 'PCIe 3.0 x4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (44, 19, 'PCIe 4.0 x4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (45, 19, 'PCIe 5.0 x4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (46, 21, '80 Plus Bronze');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (47, 21, '80 Plus Silver');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (48, 21, '80 Plus Gold');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (49, 21, '80 Plus Platinum');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (50, 21, '80 Plus Titanium');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (51, 22, 'ATX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (52, 22, 'SFX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (53, 22, 'TFX');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (148, 18, '4096');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (132, 18, '1024');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (93, 18, '1000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (63, 6, '4700');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (62, 18, '2000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (65, 39, '260');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (71, 37, '31.5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (72, 6, '4600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (82, 37, '24.5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (83, 4, '16');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (87, 6, '4200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (91, 3, '6');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (92, 37, '23.8');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (97, 5, '3400');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (98, 3, '8');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (102, 5, '3800');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (105, 39, '250');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (106, 39, '280');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (114, 3, '20');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (125, 39, '300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (140, 5, '3500');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (144, 5, '3600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (147, 39, '220');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (164, 39, '150');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (171, 39, '200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (173, 14, '32');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (178, 4, '12');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (179, 39, '180');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (99, 14, '64');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (96, 15, '3200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (90, 5, '4700');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (89, 16, '36');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (86, 35, '144');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (88, 25, '159');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (84, 24, '330');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (85, 25, '162');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (80, 25, '179');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (79, 24, '368');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (77, 5, '3300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (78, 15, '6000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (76, 25, '161');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (75, 18, '512');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (74, 3, '10');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (73, 35, '240');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (70, 5, '4300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (69, 24, '310');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (67, 6, '5600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (66, 4, '32');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (64, 20, '550');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (61, 6, '5000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (60, 24, '305');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (103, 6, '5400');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (104, 25, '168');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (107, 6, '5300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (108, 20, '750');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (109, 5, '3900');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (112, 24, '370');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (113, 15, '6400');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (115, 5, '3200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (116, 25, '190');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (117, 24, '450');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (119, 5, '2500');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (120, 25, '166');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (121, 25, '185');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (122, 6, '5500');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (124, 24, '400');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (126, 35, '100');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (129, 20, '1600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (130, 16, '20');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (131, 6, '5100');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (133, 5, '4000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (134, 5, '4200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (135, 25, '178');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (136, 3, '16');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (139, 15, '3600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (142, 25, '165');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (143, 24, '425');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (145, 35, '320');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (146, 35, '200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (149, 37, '27');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (150, 24, '365');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (151, 35, '180');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (152, 24, '349');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (154, 24, '430');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (156, 16, '18');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (157, 24, '369');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (158, 3, '18');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (159, 16, '16');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (161, 16, '17');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (160, 3, '12');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (163, 4, '18');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (166, 6, '5700');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (167, 6, '4500');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (168, 24, '410');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (170, 15, '5600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (172, 25, '180');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (174, 25, '175');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (176, 24, '415');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (177, 4, '14');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (191, 3, '14');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (192, 24, '320');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (182, 39, '320');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (183, 5, '3700');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (193, 14, '16');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (185, 6, '4400');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (194, 6, '4900');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (195, 6, '6000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (196, 20, '650');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (199, 25, '170');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (197, 37, '26.5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (200, 39, '240');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (202, 7, 'false');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (203, 38, 'false');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (204, 7, 'true');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (205, 38, 'true');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (206, 23, 'Full Tower');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (207, 36, '400 cd/m²');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (208, 23, 'Middle Tower');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (210, 34, '2560 x 1440');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (212, 36, '200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (213, 8, 'PCIe 4.0 x16');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (215, 36, '300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (216, 36, '350');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (217, 36, '250 cd/m²');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (218, 36, '300 cd/m²');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (219, 34, '3440 x 1440');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (223, 33, 'USB');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (224, 34, '2560 x 1440 (WQHD)');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (225, 36, '450');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (226, 30, 'Powietrzne');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (228, 23, 'Micro Tower');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (230, 33, 'PCI-E');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (232, 8, 'PCIe 5.0 x16');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (233, 34, '3840 x 2160 (UHD 4K)');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (235, 36, '1300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (236, 36, '400');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (237, 34, '1920 x 1080');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (238, 34, '3840 x 2160');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (242, 30, 'Wodne');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (244, 36, '250');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (101, 24, '459');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (100, 4, '20');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (81, 20, '850');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (68, 24, '315');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (111, 16, '32');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (123, 25, '163');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (137, 4, '24');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (153, 3, '24');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (165, 4, '10');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (181, 20, '600');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (180, 24, '380');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (184, 6, '5200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (186, 16, '30');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (198, 16, '46');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (189, 20, '1200');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (190, 37, '34');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (201, 20, '1000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (247, 26, 'przewodowa');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (248, 28, 'membranowe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (249, 28, 'mechaniczne');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (250, 26, 'bezprzewodowa');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (251, 28, 'membranowo-mechaniczna');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (252, 28, 'optyczno-mechaniczne');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (254, 29, 'stereo');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (255, 27, 'Optyczna');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (261, 27, 'Laserow');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (187, 18, '2048');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (300, 32, 'Wi-Fi 4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (301, 32, 'Wi-Fi 5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (302, 32, 'Wi-Fi 6');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (303, 32, 'Wi-Fi 6E');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (304, 32, 'Wi-Fi 7');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (305, 32, 'Bluetooth 5.0');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (306, 32, 'Bluetooth 5.2');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (307, 32, 'Bluetooth 5.3');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (308, 32, 'Bluetooth 5.4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (309, 32, 'LAN');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (310, 32, 'IEEE 802.1 p');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (311, 32, 'IEEE 802.1 q');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (312, 32, 'IEEE 802.3');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (313, 32, 'IEEE 802.3 ab');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (314, 32, 'IEEE 802.3 u');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (315, 32, 'IEEE 802.3 x');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (316, 32, 'IEEE 802.3 an');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (317, 32, 'IEEE 802.3 az');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (318, 32, 'IEEE 802.3 bz');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (320, 40, '269');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (321, 40, '282');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (322, 40, '225');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (323, 40, '267');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (324, 40, '337');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (325, 40, '300');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (326, 40, '297');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (327, 40, '182');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (328, 40, '320');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (329, 40, '167'); -- Intel Arc Pro B50
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (330, 40, '304'); -- ASUS Prime / Zotac Solid SFF
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (331, 40, '288'); -- Gigabyte RX 9070 XT Gaming OC
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (332, 40, '250'); -- INNO3D RTX 5060 Ti Twin X2
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (333, 40, '244'); -- Sapphire Pulse RX 9060 XT
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (334, 40, '271'); -- ASRock AI PRO R9700
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (335, 40, '312'); -- ASUS Prime RX 9070 XT
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (336, 40, '241'); -- PowerColor Fighter RX 7600
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (337, 40, '145'); -- Gigabyte RTX 5050 D6
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (338, 40, '332'); -- Zotac RTX 5080 AMP Extreme
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (339, 40, '292'); -- Palit RTX 5070 Infinity 3
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (340, 40, '221'); -- Zotac RTX 5050 Twin Edge
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (341, 40, '252'); -- Zotac RTX 5090 ArcticStorm AIO
-- Dodawanie wartości (kategoria 41: Wysokość chłodzenia powietrznego)
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (326, 40, '297');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (327, 40, '182');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (328, 40, '320');
-- Dodawanie wartości (kategoria 41: Wymiary chłodzenia)
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (400, 41, '240'); -- AiO 240
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (401, 41, '360'); -- AiO 360
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (402, 41, '159'); -- Fortis 5 / Dark Rock 5
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (403, 41, '155'); -- Fera 5 / Assassin X
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (404, 41, '154'); -- Phantom Spirit 120 SE
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (405, 41, '161'); -- Pure Rock 3
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (406, 41, '165'); -- Noctua NH-D15
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (408, 41, '157'); -- Savio Vortex X2 ARGB
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (600, 43, 'Intel 12th Gen');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (601, 43, 'Intel 13th Gen');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (602, 43, 'Intel 14th Gen');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (603, 43, 'Intel Core Ultra Gen 2');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (604, 43, 'AMD Ryzen 3000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (605, 43, 'AMD Ryzen 4000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (606, 43, 'AMD Ryzen 5000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (607, 43, 'AMD Ryzen 7000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (608, 43, 'AMD Ryzen 8000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (609, 43, 'AMD Ryzen 9000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (510, 44, '2 x DDR4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (511, 44, '4 x DDR4');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (512, 44, '2 x DDR5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (513, 44, '4 x DDR5');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (610, 42, 'Intel 12th Gen');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (611, 42, 'Intel 13th Gen');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (612, 42, 'Intel 14th Gen');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (613, 42, 'Intel Core Ultra Gen 2');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (614, 42, 'AMD Ryzen 3000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (615, 42, 'AMD Ryzen 4000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (616, 42, 'AMD Ryzen 5000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (617, 42, 'AMD Ryzen 7000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (618, 42, 'AMD Ryzen 8000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (619, 42, 'AMD Ryzen 9000');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (700, 45, '1');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (701, 45, '2');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (702, 45, '4');
-- Kategoria 46: gpu_power_connectors
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (800, 46, '6-pin PCIe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (801, 46, '8-pin (6+2) PCIe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (802, 46, '12VHPWR (16-pin)');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (803, 46, 'Brak dodatkowego zasilania');

-- Kategoria 47: cpu_power_connector
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (810, 47, '4-pin CPU');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (811, 47, '8-pin (4+4) CPU');

-- Kategoria 48: m.2_slots
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (900, 48, '1 x M.2 PCIe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (901, 48, '2 x M.2 PCIe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (902, 48, '3 x M.2 PCIe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (903, 48, '4 x M.2 PCIe');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (904, 48, '5 x M.2 PCIe');

-- Kategoria 49: radiator_size
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (910, 49, '240');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (911, 49, '280');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (912, 49, '360');

-- Kategoria 50: max_radiator
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (920, 50, '240');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (921, 50, '280');
INSERT INTO public.attribute_values (id, attribute_category_id, value) VALUES (922, 50, '360');
--
-- TOC entry 3982 (class 0 OID 17574)
-- Dependencies: 395
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.brands (id, name) VALUES (1, 'AMD');
INSERT INTO public.brands (id, name) VALUES (2, 'Intel');
INSERT INTO public.brands (id, name) VALUES (3, 'Nvidia');
INSERT INTO public.brands (id, name) VALUES (4, 'ASUS');
INSERT INTO public.brands (id, name) VALUES (5, 'MSI');
INSERT INTO public.brands (id, name) VALUES (6, 'Gigabyte');
INSERT INTO public.brands (id, name) VALUES (7, 'Palit');
INSERT INTO public.brands (id, name) VALUES (8, 'Zotac');
INSERT INTO public.brands (id, name) VALUES (9, 'Sapphire');
INSERT INTO public.brands (id, name) VALUES (10, 'PowerColor');
INSERT INTO public.brands (id, name) VALUES (11, 'Gainward');
INSERT INTO public.brands (id, name) VALUES (12, 'PNY');
INSERT INTO public.brands (id, name) VALUES (13, 'Inno3D');
INSERT INTO public.brands (id, name) VALUES (14, 'ASRock');
INSERT INTO public.brands (id, name) VALUES (15, 'EVGA');
INSERT INTO public.brands (id, name) VALUES (16, 'NZXT');
INSERT INTO public.brands (id, name) VALUES (17, 'Samsung');
INSERT INTO public.brands (id, name) VALUES (18, 'Kingston');
INSERT INTO public.brands (id, name) VALUES (19, 'Corsair');
INSERT INTO public.brands (id, name) VALUES (20, 'G.Skill');
INSERT INTO public.brands (id, name) VALUES (21, 'Crucial');
INSERT INTO public.brands (id, name) VALUES (22, 'Lexar');
INSERT INTO public.brands (id, name) VALUES (23, 'ADATA');
INSERT INTO public.brands (id, name) VALUES (24, 'XPG');
INSERT INTO public.brands (id, name) VALUES (25, 'Western Digital');
INSERT INTO public.brands (id, name) VALUES (26, 'Seagate');
INSERT INTO public.brands (id, name) VALUES (27, 'Goodram');
INSERT INTO public.brands (id, name) VALUES (28, 'Endorfy');
INSERT INTO public.brands (id, name) VALUES (29, 'be quiet');
INSERT INTO public.brands (id, name) VALUES (30, 'Seasonic');
INSERT INTO public.brands (id, name) VALUES (31, 'Lian Li');
INSERT INTO public.brands (id, name) VALUES (32, 'Noctua');
INSERT INTO public.brands (id, name) VALUES (33, 'Cooler Master');
INSERT INTO public.brands (id, name) VALUES (34, 'Fractal Design');
INSERT INTO public.brands (id, name) VALUES (35, 'Patriot');
INSERT INTO public.brands (id, name) VALUES (36, 'iiyams');
INSERT INTO public.brands (id, name) VALUES (37, 'Acer');
INSERT INTO public.brands (id, name) VALUES (38, 'Alienware');
INSERT INTO public.brands (id, name) VALUES (39, 'Lenovo');
INSERT INTO public.brands (id, name) VALUES (40, 'DELL');
INSERT INTO public.brands (id, name) VALUES (41, 'KOORUI');
INSERT INTO public.brands (id, name) VALUES (42, 'Xiaomi');
INSERT INTO public.brands (id, name) VALUES (43, 'TP-Link');
INSERT INTO public.brands (id, name) VALUES (44, 'Cudy');
INSERT INTO public.brands (id, name) VALUES (45, 'Thermalright');
INSERT INTO public.brands (id, name) VALUES (46, 'Krux');
INSERT INTO public.brands (id, name) VALUES (47, 'Genesis');
INSERT INTO public.brands (id, name) VALUES (48, 'Savio');
INSERT INTO public.brands (id, name) VALUES (49, 'SMX');
INSERT INTO public.brands (id, name) VALUES (50, 'Deepcool');
INSERT INTO public.brands (id, name) VALUES (51, 'DarkFlash');
INSERT INTO public.brands (id, name) VALUES (52, 'SteelSeries');
INSERT INTO public.brands (id, name) VALUES (53, 'Redragon');
INSERT INTO public.brands (id, name) VALUES (54, 'Dark Project');
INSERT INTO public.brands (id, name) VALUES (55, 'Logitech');
INSERT INTO public.brands (id, name) VALUES (56, 'California');
INSERT INTO public.brands (id, name) VALUES (57, 'Tracer');
INSERT INTO public.brands (id, name) VALUES (58, 'Accura');
INSERT INTO public.brands (id, name) VALUES (59, 'A4-Tech');
INSERT INTO public.brands (id, name) VALUES (60, 'Razer');
INSERT INTO public.brands (id, name) VALUES (61, 'Glorious');
INSERT INTO public.brands (id, name) VALUES (62, 'Sony');
INSERT INTO public.brands (id, name) VALUES (63, 'Apple');
INSERT INTO public.brands (id, name) VALUES (64, 'HyperX');
INSERT INTO public.brands (id, name) VALUES (65, 'JBL');
INSERT INTO public.brands (id, name) VALUES (66, 'Silver Monkey');


--
-- TOC entry 3980 (class 0 OID 17565)
-- Dependencies: 393
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.categories (id, name) VALUES (3, 'Płyta Główna');
INSERT INTO public.categories (id, name) VALUES (4, 'Ram');
INSERT INTO public.categories (id, name) VALUES (1, 'Procesor');
INSERT INTO public.categories (id, name) VALUES (2, 'Karta Graficzna');
INSERT INTO public.categories (id, name) VALUES (5, 'Dysk');
INSERT INTO public.categories (id, name) VALUES (6, 'Zasilacz');
INSERT INTO public.categories (id, name) VALUES (7, 'Obudowa');
INSERT INTO public.categories (id, name) VALUES (8, 'Myszka');
INSERT INTO public.categories (id, name) VALUES (9, 'Klawiatura');
INSERT INTO public.categories (id, name) VALUES (10, 'Słuchawki');
INSERT INTO public.categories (id, name) VALUES (11, 'Głośniki');
INSERT INTO public.categories (id, name) VALUES (12, 'Chłodzenie Procesora');
INSERT INTO public.categories (id, name) VALUES (13, 'Karty sieciowe');
INSERT INTO public.categories (id, name) VALUES (14, 'Monitor');


--
-- TOC entry 3984 (class 0 OID 17583)
-- Dependencies: 397
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (24, 5, 21, 'Crucial 2TB M.2 PCIe Gen5 NVMe P510', 1099.00, 899.00, 13, 0, 'products/storage/crucial_PCIe5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (25, 5, 21, 'Crucial 1TB M.2 PCIe Gen5 NVMe P510', 699.00, 569.00, 24, 0, 'products/storage/crucial_PCIe5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (23, 4, 35, 'Patriot 32GB (2x16GB) 6000MT/s CL30 Venom', 1599.00, NULL, 3, 0, 'products/ram/Patriot_32GB_(2x16GB)_6000MTs_CL30_Venom.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (26, 1, 2, 'Intel Core Ultra 5 245KF', 749.99, 650.00, 10, 125, 'products/cpu/Intel_Core_Ultra_5_245KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (27, 1, 2, 'Intel Core Ultra 5 225F', 685.00, NULL, 10, 65, 'products/cpu/Intel_Core_Ultra_5_225F.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (29, 1, 1, 'AMD Ryzen 5 7600X', 760.00, NULL, 13, 105, 'products/cpu/AMD_Ryzen_5_7600X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (30, 1, 1, 'AMD Ryzen 5 7600', 730.00, 630.00, 13, 65, 'products/cpu/AMD_Ryzen_5_7600X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (28, 4, 27, 'GOODRAM 32GB (2x16GB) 6400MHz CL32 IRDM BLACK V SILVER', 1649.00, NULL, 4, 0, 'products/ram/GOODRAM_32GB_(2x16GB)_6400MHz_CL32_IRDM_BLACK_V_SILVER.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (31, 4, 18, 'Kingston FURY 16GB (2x8GB) 3200MHz CL16 Beast Black', 699.00, NULL, 8, 0, 'products/ram/Kingston_FURY_16GB_(2x8GB)_3200MHz_CL16_Beast_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (32, 4, 27, 'GOODRAM 32GB (2x16GB) 6000MHz CL30 IRDM BLACK V SILVER', 1799.00, 1645.00, 3, 0, 'products/ram/GOODRAM_32GB_(2x16GB)_6000MHz_CL30_IRDM_BLACK_V_SILVER.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (33, 4, 18, 'Kingston FURY 32GB (2x16GB) 5600MHz CL36 Beast Black EXPO AMD', 1849.00, NULL, 2, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_5600MHz_CL36_Beast_Black_EXPO_AMD.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (34, 4, 35, 'Patriot 32GB (2x16GB) 6000MHz CL36 VIPER VENOM', 1769.00, NULL, 4, 0, 'products/ram/Patriot_32GB_(2x16GB)_6000MHz_CL36_VIPER_VENOM.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (35, 1, 1, 'AMD Ryzen 7 7800X3D Tray', 1230.00, 1100.00, 13, 65, 'products/cpu/AMD_Ryzen_7_7800X3D_Tray.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (36, 4, 18, 'Kingston FURY 32GB (2x16GB) 6000MT/s CL30 Beast Black EXPO', 1859.00, 1719.00, 4, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_6000MTs_CL30_Beast_Black_EXPO.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (37, 2, 6, 'Gigabyte Radeon RX 9060 XT Gaming OC 16GB GDDR6', 2099.00, 1839.00, 15, 150, 'products/gpu/Gigabyte_Radeon_RX_9060_XT_Gaming_OC_16GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (38, 1, 1, 'AMD Ryzen 7 9800X3D', 1959.00, 1849.00, 7, 120, 'products/cpu/AMD_Ryzen 7_9800X3D.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (1, 1, 1, 'AMD Ryzen 5 5600', 580.00, NULL, 5, 65, 'products/cpu/Ryzen5_5600.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (2, 1, 1, 'AMD Ryzen 5 5500', 299.00, NULL, 5, 65, 'products/cpu/Ryzen5_5600.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (3, 1, 1, 'AMD Ryzen 5 5600XT', 609.00, NULL, 5, 65, 'products/cpu/Ryzen5_5600.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (5, 1, 1, 'AMD Ryzen 7 5800X', 830.00, NULL, 5, 105, 'products/cpu/Ryzen7_5800X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (4, 1, 1, 'AMD Ryzen 7 5700X', 780.00, NULL, 5, 65, 'products/cpu/Ryzen7_5800X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (53, 2, 2, 'Intel Arc Pro B50 16GB GDDR6', 1799.00, NULL, 10, 135, 'products/gpu/Intel_Arc_Pro_B50_16GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (48, 2, 5, 'MSI GeForce RTX 5070 Ti Gaming Trio OC 16GB GDDR7', 4800.00, NULL, 10, 130, 'products/gpu/MSI_GeForce_RTX_5070_Ti_Gaming_Trio_OC_16GB_GDDR7.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (39, 4, 20, 'G.SKILL 32GB (2x16GB) 3200MHz CL16 Aegis', 1199.00, NULL, 5, 0, 'products/ram/G.SKILL_32GB_(2x16GB)_3200MHz_CL16_Aegis.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (40, 4, 22, 'Lexar 32GB (2x16GB) 6000 CL30 Ares RGB', 1859.00, NULL, 3, 0, 'products/ram/Lexar_32GB_(2x16GB)_6000_CL30_Ares_RGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (16, 5, 27, 'GOODRAM 512GB M.2 PCIe NVMe PX500 G3', 449.00, NULL, 5, 0, 'GOODRAM_512GB_M.2.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (17, 5, 22, 'Lexar 4TB M.2 PCIe Gen5 NVMe NM990', 2399.00, NULL, 4, 0, 'products/storage/lexar_m.2_gen5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (18, 5, 22, 'Lexar 2TB M.2 PCIe Gen5 NVMe NM990', 1299.00, NULL, 11, 0, 'products/storage/lexar_m.2_gen5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (19, 5, 22, 'Lexar 1TB M.2 PCIe Gen5 NVMe NM990', 839.00, NULL, 19, 0, 'products/storage/lexar_m.2_gen5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (20, 5, 18, 'Kingston 4TB M.2 PCIe Gen5 NVMe Fury Renegade G5', 2799.00, NULL, 5, 0, 'products/storage/kingston_fury_PCIe5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (21, 5, 18, 'Kingston 2TB M.2 PCIe Gen5 NVMe Fury Renegade G5', 1599.00, NULL, 10, 0, 'products/storage/kingston_fury_PCIe5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (22, 5, 18, 'Kingston 1TB M.2 PCIe Gen5 NVMe Fury Renegade G5', 1049.00, NULL, 14, 0, 'products/storage/kingston_fury_PCIe5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (41, 1, 2, 'Intel Core i7-14700KF', 1460.00, NULL, 5, 125, 'products/cpu/IntelCorei7-14700KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (42, 4, 27, 'GOODRAM 32GB (2x16GB) 6000 CL36 IRDM BLACK V SILVER', 1675.00, NULL, 4, 0, 'products/ram/GOODRAM_32GB_(2x16GB)_6000_CL36_IRDM_BLACK_V_SILVER.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (43, 4, 18, 'Kingston FURY 32GB (2x16GB) 3200MHz CL16 Beast Black', 1149.00, 1099.00, 5, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_3200MHz_CL16_Beast_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (49, 2, 5, 'Gigabyte GeForce RTX 5080 Windforce OC 16GB GDDR7 DLSS4', 5999.00, NULL, 10, 135, 'products/gpu/Gigabyte_GeForce_RTX_5080_Windforce_OC_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (50, 2, 4, 'ASUS GeForce RTX 5080 Prime OC 16GB GDDR7 DLSS4', 6499.00, NULL, 10, 145, 'products/gpu/Gigabyte_GeForce_RTX_5080_Windforce_OC_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (14, 2, 14, 'Karta graficzna ASRock RX 6700 XT Challenger D 12 GB', 1600.00, NULL, 3, 230, 'products/gpu/RX6700_XT.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (15, 2, 14, 'ASRock Radeon RX 6600 Challenger D 8GB GDDR6', 1000.00, NULL, 4, 130, 'products/gpu/RX_6600.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (44, 2, 5, 'MSI GeForce RTX 5060 Ventus 2X OC 8GB GDDR7 DLSS4', 1399.00, 1000.00, 20, 145, 'products/gpu/MSI_GeForce_RTX_5060_Ventus_2X_OC_8GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (46, 2, 6, 'Gigabyte Radeon RX 9070 XT Gaming OC 16GB GDDR6', 3199.00, NULL, 8, 125, 'products/gpu/Zotac_GeForce_RTX_5070_Ti_Solid_SFF_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (47, 2, 6, 'ASUS GeForce RTX 5070 Dual OC 12GB GDDR7 DLSS4', 2899.00, NULL, 14, 115, 'products/gpu/ASUS_GeForce_RTX_5070_Dual_OC_12GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (51, 2, 13, 'INNO3D GeForce RTX 5080 X3 OC 16GB GDDR7 DLSS4', 5999.00, NULL, 10, 145, 'products/gpu/INNO3D_GeForce_RTX_5080_X3_OC_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (54, 2, 9, 'Sapphire Radeon RX 9060 XT Pure OC 16GB GDDR6', 2299.00, NULL, 10, 155, 'products/gpu/Sapphire_Radeon_RX_9060_XT_Pure_OC_16GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (55, 2, 4, 'ASUS GeForce RTX 5070 Ti Prime OC 16GB GDDR7 DLSS4', 5299.00, NULL, 10, 165, 'products/gpu/ASUS_GeForce_RTX_5070_Ti_Prime_OC_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (56, 2, 13, 'INNO3D GeForce RTX 5060 Ti Twin X2 OC 16GB GDDR7 DLSS4', 2499.00, NULL, 10, 135, 'products/gpu/INNO3D_GeForce_RTX_5060_Ti_Twin_X2_OC_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (57, 2, 9, 'Sapphire Radeon RX 9060 XT Pulse OC 8GB GDDR6', 2039.00, NULL, 10, 115, 'products/gpu/Sapphire_Radeon_RX_9060_XT_Pulse_OC_8GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (58, 2, 14, 'ASRock Radeon AI PRO R9700 Creator 32GB GDDR6', 7819.00, NULL, 10, 125, 'products/gpu/ASRock_Radeon_AI_PRO_R9700_Creator_32GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (60, 2, 4, 'ASUS Radeon RX 9070 XT Prime OC White 16GB GDDR6', 3500.00, NULL, 10, 125, 'products/gpu/ASUS_Radeon_RX_9070_XT_Prime_OC_White_16GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (61, 2, 10, 'PowerColor Radeon RX 7600 Fighter 8GB V2 GDDR6', 1000.00, NULL, 10, 125, 'products/gpu/PowerColor_Radeon_RX_7600_Fighter_8GB_V2_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (63, 2, 4, 'ASUS Radeon RX 9070 Prime EVO OC 16GB GDDR6', 3000.00, NULL, 10, 145, 'products/gpu/ASUS_Radeon_RX_9070_Prime_EVO_OC_16GB_GDDR6.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (64, 2, 6, 'Gigabyte GeForce RTX 5050 D6 8GB GDDR6 DLSS4', 1300.00, NULL, 10, 135, 'products/gpu/Gigabyte_GeForce_RTX_5050_D6_8GB_GDDR6_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (66, 2, 4, 'ASUS GeForce RTX 5070 Ti ROG Strix OC 16GB GDDR7 DLSS4', 5500.00, NULL, 10, 145, 'products/gpu/ASUS_GeForce_RTX_5070_Ti_ROG_Strix_OC_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (67, 2, 4, 'Zotac GeForce RTX 5080 AMP Extreme Infinity 16GB GDDR7 DLSS4', 6300.00, NULL, 10, 145, 'products/gpu/Zotac_GeForce_RTX_5080_AMP_Extreme_Infinity_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (68, 2, 7, 'Palit GeForce RTX 5070 Infinity 3 12GB GDDR7 DLSS4', 2900.00, NULL, 10, 145, 'products/gpu/Palit_GeForce_RTX_5070_Infinity_3_12GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (69, 2, 6, 'Gigabyte GeForce RTX 5060 Aero OC 8GB GDDR7 DLSS4', 1800.00, NULL, 10, 145, 'products/gpu/Gigabyte_GeForce_RTX_5060_Aero_OC_8GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (71, 4, 18, 'Kingston FURY 32GB (2x16GB) 6000MTs CL30 Beast Black RGB', 2073.00, NULL, 2, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_6000MTs_CL30_Beast_Black_RGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (72, 4, 23, 'ADATA 32GB (2x16GB) 6000MHz CL30 Lancer Blade', 1963.00, NULL, 3, 0, 'products/ram/ADATA_32GB_(2x16GB)_6000MHz_CL30_Lancer_Blade.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (74, 4, 18, 'Kingston FURY 16GB (2x8GB) 5600MHz CL36 Beast Black EXPO', 1259.00, NULL, 5, 0, 'products/ram/Kingston_FURY_16GB_(2x8GB)_5600MHz_CL36_Beast_Black_EXPO.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (75, 4, 27, 'GOODRAM 64GB (2x32GB) 6000MHz CL30 IRDM BLACK V SILVER', 2558.00, 2519.00, 2, 0, 'products/ram/GOODRAM_64GB_(2x32GB)_6000MHz_CL30_IRDM_BLACK_V_SILVER.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (76, 4, 27, 'GOODRAM 32GB (2x16GB) 3600MHz CL18 IRDM PRO Deep Black', 1099.00, 959.00, 8, 0, 'products/ram/GOODRAM_32GB_(2x16GB)_3600MHz_CL18_IRDM_PRO_Deep_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (77, 4, 35, 'Patriot 32GB (2x16GB) 6000MHz CL36 VIPER VENOM RGB', 1999.00, NULL, 4, 0, 'products/ram/Patriot_32GB_(2x16GB)_6000MHz_CL36_VIPER_VENOM_RGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (78, 4, 21, 'Crucial 32GB (2x16GB) 6000MHz CL36 Pro Overclocking', 1999.00, NULL, 5, 0, 'products/ram/Crucial_32GB_(2x16GB)_6000MHz_CL36_Pro_Overclocking.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (80, 4, 35, 'Patriot 32GB(2x16GB) 6000MTs CL30 Venom RGB', 1870.00, NULL, 6, 0, 'products/ram/Patriot_32GB(2x16GB)_6000MTs_CL30_Venom_RGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (81, 14, 36, 'iiyama G-Master GCB3486WQSCP-B1 Gold Phoenix', 1700.00, NULL, 12, 45, 'products/monitor/iiyama_G-Master_GCB3486WQSCP-B1_Gold_Phoenix.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (82, 4, 18, 'Kingston FURY 64GB (2x32GB) 6000MTs CL30 Beast Black RGB', 3699.00, NULL, 1, 0, 'products/ram/Kingston_FURY_64GB_(2x32GB)_6000MTs_CL30_Beast_Black_RGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (83, 4, 18, 'Kingston FURY 32GB (2x16GB) 3200MHz CL20 Impact', 1019.00, NULL, 7, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_3200MHz_CL20_Impact.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (84, 4, 18, 'Kingston FURY 16GB (2x8GB) 3600MHz CL16 Renegade Black', 709.00, 699.00, 11, 0, 'products/ram/Kingston_FURY_16GB_(2x8GB)_3600MHz_CL16_Renegade_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (85, 4, 18, 'Kingston FURY 32GB (2x16GB) 3600MHz CL16 Renegade Black', 1329.00, NULL, 4, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_3600MHz_CL16_Renegade_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (86, 4, 18, 'Kingston FURY 32GB (2x16GB) 6000 CL36 FURY Beast White', 2019.00, NULL, 2, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_6000_CL36_FURY_Beast_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (45, 2, 5, 'Zotac GeForce RTX 5070 Ti Solid SFF 16GB GDDR7 DLSS4', 4249.00, NULL, 12, 135, 'products/gpu/Zotac_GeForce_RTX_5070_Ti_Solid_SFF_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (52, 2, 5, 'Zotac GeForce RTX 5060 Twin Edge OC White 8GB GDDR7 DLSS4', 1599.00, NULL, 10, 135, 'products/gpu/Zotac_GeForce_RTX_5060_Twin_Edge_OC_White_8GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (59, 2, 5, 'Zotac GeForce RTX 5090 ArcticStorm AIO 32GB GDDR7 DLSS4', 18999.00, NULL, 10, 125, 'products/gpu/Zotac_GeForce_RTX_5090_ArcticStorm_AIO_32GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (62, 2, 5, 'Zotac GeForce RTX 5050 Low Profile 8GB GDDR6 DLSS4', 1250.00, NULL, 10, 125, 'products/gpu/Zotac_GeForce_RTX_5050_Low_Profile_8GB_GDDR6_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (65, 2, 5, 'Zotac GeForce RTX 5060 Ti Twin Edge OC White 16GB GDDR7 DLSS4', 2500.00, NULL, 10, 135, 'products/gpu/Zotac_GeForce_RTX_5060_Ti_Twin_Edge_OC_White_16GB_GDDR7_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (70, 2, 5, 'Zotac GeForce RTX 5050 Twin Edge OC 8GB GDDR6 DLSS4', 1400.00, NULL, 10, 145, 'products/gpu/Zotac_GeForce_RTX_5050_Twin_Edge_OC_8GB_GDDR6_DLSS4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (73, 14, 5, 'MSI MPG 321URX QD-OLED', 2700.00, NULL, 12, 45, 'products/monitor/MSI_MPG_321URX_QD-OLED.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (87, 4, 19, 'Corsair 32GB (2x16GB) 6000 CL36 Vengeance RGB AMD EXPO', 2129.00, NULL, 3, 0, 'products/ram/Corsair_32GB_(2x16GB)_6000_CL36_Vengeance_RGB_AMD_EXPO.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (88, 4, 21, 'Crucial 16GB (1x16GB) 5600MHz CL46', 999.00, NULL, 6, 0, 'products/ram/Crucial_16GB_(1x16GB)_5600MHz_CL46.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (89, 4, 18, 'Kingston FURY 16GB (2x8GB) 3600MHz CL17 Beast Black', 799.00, NULL, 15, 0, 'products/ram/Kingston_FURY_16GB_(2x8GB)_3600MHz_CL17_Beast_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (90, 4, 27, 'GOODRAM 32GB (2x16GB) 5600 CL36 IRDM', 1669.00, NULL, 7, 0, 'products/ram/GOODRAM_32GB_(2x16GB)_5600_CL36_IRDM.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (91, 4, 18, 'Kingston FURY 32GB (2x16GB) 6000MHz CL36 Beast Black', 2169.00, NULL, 4, 0, 'products/ram/Kingston_FURY_32GB_(2x16GB)_6000MHz_CL36_Beast_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (92, 14, 37, 'Acer SA242YH1', 270.00, NULL, 12, 45, 'products/monitor/Acer_SA242YH1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (93, 4, 35, 'Patriot 64GB (2x32GB) 6000MTs CL30 Venom', 2999.00, 2579.00, 4, 0, 'products/ram/Patriot_64GB_(2x32GB)_6000MTs_CL30_Venom.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (94, 14, 17, 'Samsung Odyssey  G5 S27FG502EUX G50F', 600.00, NULL, 10, 21, 'products/monitor/Samsung_Odyssey__G5_S27FG502EUX_G50F.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (95, 14, 38, 'Dell Alienware AW2725DM', 900.00, 800.00, 12, 21, 'products/monitor/Dell_Alienware_AW2725DM.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (96, 14, 6, 'Gigabyte G25F2A', 480.00, NULL, 11, 21, 'products/monitor/Gigabyte_G25F2A.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (97, 14, 6, 'Gigabyte G25F2A', 480.00, NULL, 11, 21, 'products/monitor/Gigabyte_G25F2A.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (98, 14, 6, 'MSI MPG 321URXW QD-OLED', 3000.00, NULL, 4, 44, 'products/monitor/MSI_MPG_321URXW_QD-OLED.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (99, 14, 6, 'MSI MPG 321URXW QD-OLED', 3000.00, NULL, 4, 44, 'products/monitor/MSI_MPG_321URXW_QD-OLED.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (100, 14, 17, 'Samsung Odyssey  G5 S27FG500SUX G50SF', 1549.00, NULL, 13, 28, 'products/monitor/Samsung_Odyssey__G5_S27FG500SUX_G50SF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (101, 14, 39, 'Lenovo Legion 24-10', 469.00, NULL, 3, 34, 'products/monitor/Lenovo_Legion_24-10.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (102, 14, 36, 'iiyama G-Master GB2771QSU-B1 Red Eagle', 800.00, NULL, 9, 34, 'products/monitor/iiyama_G-Master_GB2771QSU-B1_Red_Eagle.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (103, 14, 37, 'Acer Predator X27UW3bmiiprx', 1600.00, NULL, 19, 25, 'products/monitor/Acer_Predator_X27UW3bmiiprx.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (104, 14, 4, 'ASUS ROG Strix OLED XG27AQDMGR', 2140.00, NULL, 16, 25, 'products/monitor/ASUS_ROG_Strix_OLED_XG27AQDMGR.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (105, 14, 39, 'Lenovo Legion 25-10', 550.00, NULL, 6, 18, 'products/monitor/Lenovo_Legion_25-10.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (106, 14, 5, 'MSI PRO MP242L', 290.00, NULL, 6, 14, 'products/monitor/MSI_PRO_MP242L.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (107, 14, 40, 'Dell P2425H', 600.00, NULL, 10, 12, 'products/monitor/Dell_P2425H.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (108, 14, 41, 'KOORUI G2722P IPS 200 Hz 1ms', 700.00, NULL, 10, 12, 'products/monitor/KOORUI_G2722P_IPS_200_Hz_1ms.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (110, 14, 42, 'Xiaomi Curved Gaming Monitor G34WQi', 1100.00, 900.00, 20, 31, 'products/monitor/Xiaomi_Curved_Gaming_Monitor_G34WQi.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (111, 14, 36, 'iiyama G-Master GB2771UHSU-B1 Red Eagle', 1300.00, NULL, 2, 26, 'products/monitor/iiyama_G-Master_GB2771UHSU-B1_Red_Eagle.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (112, 6, 29, 'be quiet! Pure Power 13 M 850W 80 Plus Gold', 599.00, NULL, 10, 0, 'products/psu/be_quiet!_Pure_Power_13_M_850W_80_Plus_Gold.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (113, 6, 29, 'be quiet! Power Zone 2 1000W 80 PLUS Platinum', 799.00, NULL, 8, 0, 'products/psu/be_quiet!_Power_Zone_2_1000W_80_PLUS_Platinum.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (114, 13, 4, 'ASUS PCE-AXE5400 (5400Mb/s a/b/g/n/ac/ax) BT 5.2', 139.00, NULL, 11, 2, 'products/network/ASUS_PCE-AXE5400_(5400Mb_s_a_b_g_n_ac_ax)_BT_5.2.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (115, 6, 28, 'ENDORFY Supremo FM6 1000W 80 Plus Gold ATX 3.1', 649.00, NULL, 9, 0, 'products/psu/ENDORFY_Supremo_FM6_1000W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (116, 6, 6, 'Gigabyte UD750GM PG5 V2 750W 80 Plus Gold ATX 3.1', 359.00, NULL, 15, 0, 'products/psu/Gigabyte_UD750GM_PG5_V2_750W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (117, 6, 29, 'be quiet! System Power 11 750W 80 Plus Bronze', 349.00, NULL, 16, 0, 'products/psu/be_quiet!_System_Power_11_750W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (119, 6, 28, 'ENDORFY Supremo FM6 750W 80 Plus Gold ATX 3.1', 449.00, NULL, 13, 0, 'products/psu/ENDORFY_Supremo_FM6_750W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (120, 6, 29, 'be quiet! Dark Power 14 850W 80 Plus Titanium ATX 3.1', 899.00, NULL, 7, 0, 'products/psu/be_quiet!_Dark_Power_14_850W_80_Plus_Titanium_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (121, 6, 5, 'MSI MAG 650W 80 Plus Bronze', 249.00, NULL, 17, 0, 'products/psu/MSI_MAG_650W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (122, 6, 5, 'MSI MPG A850G PCIe5.0 850W 80 Plus Gold ATX 3.1', 529.00, NULL, 12, 0, 'products/psu/MSI_MPG_A850G_PCIe5.0_850W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (123, 13, 44, 'Cudy PE10 (10/100/1000Mbit)', 30.00, NULL, 21, 2, 'products/network/Cudy_PE10_(10_100_1000Mbit).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (124, 6, 5, 'MSI MAG 550W 80 Plus Bronze', 199.00, NULL, 25, 0, 'products/psu/MSI_MAG_550W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (125, 6, 29, 'be quiet! Pure Power 13 M 750W 80 Plus Gold', 499.00, NULL, 14, 0, 'products/psu/be_quiet!_Pure_Power_13_M_750W_80_Plus_Gold.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (126, 13, 4, 'ASUS ROG USB-BE92 (6500Mb/s a/b/g/n/ac/ax/be)', 440.00, NULL, 21, 2, 'products/network/ASUS_ROG_USB-BE92_(6500Mb_s_a_b_g_n_ac_ax_be).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (127, 6, 28, 'ENDORFY Supremo FM6 850W 80 Plus Gold ATX 3.1', 549.00, NULL, 11, 0, 'products/psu/ENDORFY_Supremo_FM6_850W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (129, 6, 28, 'ENDORFY Vero L5 600W 80 Plus Bronze', 249.00, NULL, 15, 0, 'products/psu/ENDORFY_Vero_L5_600W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (130, 6, 29, 'be quiet! System Power 11 550W 80 Plus Bronze', 249.00, NULL, 16, 0, 'products/psu/be_quiet!_System_Power_11_550W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (131, 6, 29, 'be quiet! Dark Power 14 1000W 80 Plus Titanium ATX 3.1', 1119.00, NULL, 4, 0, 'products/psu/be_quiet!_Dark_Power_14_1000W_80_Plus_Titanium_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (132, 6, 19, 'Corsair HXi Shift 1000W 80 Plus Platinum', 999.00, NULL, 5, 0, 'products/psu/Corsair_HXi_Shift_1000W_80_Plus_Platinum.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (134, 6, 19, 'Corsair RM650e 650W 80 Plus Gold ATX 3.1', 349.00, NULL, 17, 0, 'products/psu/Corsair_RM650e_650W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (136, 6, 29, 'be quiet! Dark Power 14 1200W 80 Plus Titanium ATX 3.1', 1399.00, NULL, 3, 0, 'products/psu/be_quiet!_Dark_Power_14_1200W_80_Plus_Titanium_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (139, 6, 34, 'Fractal Design Ion 3 Gold 1000W 80 Plus Gold', 799.00, NULL, 7, 0, 'products/psu/Fractal_Design_Ion_3_Gold_1000W_80_Plus_Gold.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (141, 6, 34, 'Fractal Design Ion 3 Gold 850W 80 Plus Gold', 599.00, NULL, 6, 0, 'products/psu/Fractal_Design_Ion_3_Gold_850W_80_Plus_Gold.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (144, 6, 19, 'Corsair RM850e 850W 80 Plus Gold ATX 3.1', 539.00, 439.00, 7, 0, 'products/psu/Corsair_RM850e_850W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (147, 6, 19, 'Corsair RM750e 750W 80 Plus Gold ATX 3.1', 489.00, 389.00, 8, 0, 'products/psu/Corsair_RM750e_750W_80_Plus_Gold_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (128, 13, 43, 'TP-Link Archer TBE550E (9300Mb/s a/b/g/n/ac/ax/be) BT 5.4', 150.00, 100.00, 21, 2, 'products/network/TP-Link_Archer_TBE550E_(9300Mb_s_a_b_g_n_ac_ax_be)_BT_5.4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (133, 13, 43, 'TP-Link TG-3468 (10/100/1000Mbit)', 155.00, 129.00, 21, 2, 'products/network/TP-Link_TG-3468_(10_100_1000Mbit).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (118, 13, 43, 'TP-Link Archer T3U Plus (1300Mb/s a/b/g/n/ac) DualBand', 89.90, NULL, 11, 2, 'products/network/TP-Link_Archer_T3U_Plus_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (135, 13, 43, 'TP-Link Archer TX3000E (3000Mb/s a/b/g/n/ac/ax) BT 5.0', 255.00, NULL, 21, 2, 'products/network/TP-Link_Archer_TX3000E_(3000Mb_s_a_b_g_n_ac_ax)_BT_5.0.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (148, 6, 5, 'MSI MEG Ai1600T PCIE5 1600W 80 Plus Titanium', 2999.00, NULL, 2, 0, 'products/psu/MSI_MEG_Ai1600T_PCIE5_1600W_80_Plus_Titanium.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (160, 13, 43, 'TP-Link TL-WN881ND (802.11b/g/n 300Mb/s)', 64.00, NULL, 21, 2, 'products/network/TP-Link_TL-WN881ND_(802.11b_g_n_300Mb_s).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (161, 13, 43, 'TP-Link TL-WN821N (802.11b/g/n 300Mb/s)', 44.00, NULL, 21, 2, 'products/network/TP-Link_TL-WN821N_(802.11b_g_n_300Mb_s).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (162, 13, 43, 'TP-Link TL-WN822N (802.11b/g/n 300Mb/s)', 59.00, NULL, 21, 2, 'products/network/TP-Link_TL-WN822N_(802.11b_g_n_300Mb_s).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (163, 6, 33, 'Cooler Master MWE Bronze V3 650W 80 PLUS Bronze ATX 3.1', 249.00, NULL, 14, 0, 'products/psu/Cooler_Master_MWE_Bronze_V3_650W_80_PLUS_Bronze_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (164, 1, 1, 'AMD Ryzen 5 7500X3D', 999.00, 950.00, 12, 65, 'products/cpu/AMD_Ryzen_5_7500X3D.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (166, 1, 1, 'AMD Ryzen 9 9950X3D', 2949.00, NULL, 7, 170, 'products/cpu/AMD_Ryzen_9_9950X3D.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (165, 1, 1, 'AMD Ryzen 7 9700X', 1366.00, 1300.00, 10, 65, 'products/cpu/AMD_Ryzen_7_9700X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (142, 13, 43, 'TP-Link Archer TXE75E (5400Mb/s a/b/g/n/ac/ax)', 100.00, 89.90, 21, 2, 'products/network/TP-Link_Archer_TXE75E_(5400Mb_s_a_b_g_n_ac_ax).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (167, 1, 1, 'AMD Ryzen 5 9600X', 919.00, NULL, 12, 65, 'products/cpu/AMD_Ryzen_5_9600X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (168, 1, 1, 'AMD Ryzen 7 9850X3D', 2149.00, NULL, 5, 120, 'products/cpu/AMD_Ryzen_7_9850X3D.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (169, 1, 2, 'Intel Core i9-14900K', 2099.00, 1750.00, 5, 125, 'products/cpu/Intel_Core_i9-14900K.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (149, 6, 6, 'Gigabyte Aorus Elite P 850W 80 Plus Platinum ATX 3.1', 399.00, 389.00, 17, 0, 'products/psu/Gigabyte_Aorus_Elite_P_850W_80_Plus_Platinum_ATX_3.1.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (170, 1, 2, 'Intel Core i9-14900KF', 1899.00, 1600.00, 5, 125, 'products/cpu/Intel_Core_i9-14900KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (171, 1, 2, 'Intel Core i5-12400F', 649.00, NULL, 12, 65, 'products/cpu/Intel_Core_i5-12400F.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (172, 1, 2, 'Intel Core Ultra 7 265KF', 1099.00, 1050.00, 12, 125, 'products/cpu/Intel_Core_Ultra_7_265KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (140, 13, 43, 'TP-Link Archer TXE72E (5400Mb/s a/b/g/n/ac/ax) BT 5.3', 134.00, NULL, 21, 2, 'products/network/TP-Link_TX401_(100_1000Mbit_10Gbit).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (150, 6, 14, 'ASRock Challenger 550W 80 Plus Bronze', 279.00, NULL, 18, 0, 'products/psu/ASRock_Challenger_550W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (173, 1, 1, 'AMD Ryzen 5 8400F', 589.00, NULL, 11, 65, 'products/cpu/AMD_Ryzen_5_8400F.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (143, 13, 43, 'TP-Link Archer T3U Nano (1300Mb/s a/b/g/n/ac) DualBand', 434.00, NULL, 21, 2, 'products/network/TP-Link_Archer_T3U_Nano_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (174, 1, 1, 'AMD Ryzen 5 8500G', 599.00, NULL, 12, 65, 'products/cpu/AMD_Ryzen_5_8500G.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (145, 13, 43, 'TP-Link Archer TX20E (1800Mb s a b g n ac ax) BT 5.2', 334.00, 200.00, 21, 2, 'products/network/TP-Link_Archer_T3U_Nano_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (175, 1, 2, 'Intel Core i5-14400F Tray', 669.00, 640.00, 12, 65, 'products/cpu/Intel_Core_i5-14400F_Tray.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (146, 13, 43, 'TP-Link Archer TX20U (1800Mb/s a/b/g/n/ac/ax)', 123.45, 100.00, 21, 2, 'products/network/TP-Link_Archer_TX20U_(1800Mb_s_a_b_g_n_ac_ax).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (151, 6, 14, 'ASRock Challenger 650W 80 Plus Bronze', 309.00, NULL, 9, 0, 'products/psu/ASRock_Challenger_650W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (152, 6, 14, 'ASRock Challenger 750W 80 Plus Bronze', 349.00, NULL, 11, 0, 'products/psu/ASRock_Challenger_750W_80_Plus_Bronze.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (153, 6, 14, 'ASRock Challenger 850W 80 Plus Gold', 449.00, NULL, 10, 0, 'products/psu/ASRock_Challenger_850W_80_Plus_Gold.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (154, 13, 43, 'TP-Link Archer T3U (1300Mb/s a/b/g/n/ac) DualBand', 69.01, NULL, 21, 2, 'products/network/TP-Link_Archer_T3U_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (155, 13, 43, 'TP-Link Archer TXE70UH (5400Mb/s a/b/g/n/ac/ax)', 219.00, NULL, 21, 2, 'products/network/TP-Link_Archer_TXE70UH_(5400Mb_s_a_b_g_n_ac_ax).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (156, 13, 43, 'TP-Link Archer T2U Nano (600Mb/s a/b/g/n/ac) DualBand', 49.00, NULL, 21, 2, 'products/network/TP-Link_Archer_T2U_Nano_(600Mb_s_a_b_g_n_ac)_DualBand.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (157, 13, 43, 'TP-Link TL-WN781ND (802.11b/g/n 150Mb/s)', 48.00, 45.00, 21, 2, 'products/network/TP-Link_TL-WN781ND_(802.11b_g_n_150Mb_s).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (158, 13, 43, 'TP-Link Archer TBE400E (6500Mb/s a/b/g/n/ac/ax/be) BT 5.4', 259.00, NULL, 21, 2, 'products/network/TP-Link_Archer_TBE400E_(6500Mb_s_a_b_g_n_ac_ax_be)_BT_5.4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (159, 13, 43, 'TP-Link TX201 (2,5Gb/s) Low Profle', 93.00, NULL, 21, 2, 'products/network/TP-Link_TX201_(2,5Gb_s)_Low_Profle.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (188, 3, 4, 'ASUS PRIME Z790-P WIFI', 794.00, NULL, 11, 0, 'products/motherboard/ASUS_PRIME_Z790-P_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (176, 1, 2, 'Intel Core Ultra 5 225', 729.00, NULL, 10, 65, 'products/cpu/Intel_Core_Ultra_5_225F.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (177, 1, 2, 'Intel Core Ultra 5 250KF Plus', 899.00, NULL, 14, 125, 'products/cpu/Intel_Core_Ultra_5_250KF_Plus.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (178, 1, 2, 'Intel Core i5-14600KF', 969.00, 930.00, 14, 125, 'products/cpu/Intel_Core_i5-14600KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (179, 1, 2, 'Intel Core i5-12600KF', 799.00, NULL, 12, 125, 'products/cpu/Intel_Core_i5-12600KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (180, 1, 2, 'Intel Core i7-12700KF', 1119.00, 1070.00, 10, 125, 'products/cpu/Intel_Core_i7-12700KF.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (181, 1, 2, 'Intel Core Ultra 9 285', 2511.00, 2300.00, 7, 65, 'products/cpu/Intel_Core_Ultra_9_285.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (182, 3, 4, 'ASUS TUF GAMING B860-PLUS WIFI', 760.99, NULL, 23, 0, 'products/motherboard/ASUS_TUF_GAMING_B860-PLUS_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (184, 3, 4, 'ASUS B850M MAX GAMING WIFI', 869.00, 790.00, 15, 0, 'products/motherboard/ASUS_B850M_MAX_GAMING_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (185, 3, 4, 'ASUS PRIME B760M-A WIFI D4', 519.99, NULL, 15, 0, 'products/motherboard/ASUS_PRIME_B760M-A_WIFI_D4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (183, 3, 4, 'ASUS TUF GAMING B850-PLUS WIFI', 830.00, NULL, 21, 0, 'products/motherboard/ASUS_TUF_GAMING_B850-PLUS_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (186, 3, 4, 'ASUS PRIME B550M-A', 339.00, NULL, 13, 0, 'products/motherboard/ASUS_PRIME_B550M-A.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (187, 3, 4, 'ASUS TUF GAMING B650E-E WIFI', 639.00, NULL, 13, 0, 'products/motherboard/ASUS_TUF_GAMING_B650E-E_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (189, 3, 6, 'Gigabyte B650 EAGLE AX', 565.00, 530.00, 17, 0, 'products/motherboard/Gigabyte_B650_EAGLE_AX.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (190, 3, 6, 'Gigabyte B550 GAMING X V2', 396.00, NULL, 17, 0, 'products/motherboard/Gigabyte_B550_GAMING_X_V2.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (191, 3, 6, 'Gigabyte B760M DS3H DDR4', 387.00, NULL, 13, 0, 'products/motherboard/Gigabyte_B760M_DS3H_DDR4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (192, 3, 6, 'Gigabyte B650 GAMING X AX V2', 616.00, 580.00, 11, 0, 'products/motherboard/Gigabyte_B650_GAMING_X_AX_V2.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (193, 3, 6, 'Gigabyte B650M S2H', 395.00, NULL, 9, 0, 'products/motherboard/Gigabyte_B650M_S2H.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (194, 3, 6, 'Gigabyte B760M DS3H WF6E GEN5', 599.00, NULL, 9, 0, 'products/motherboard/Gigabyte_B760M_DS3H_WF6E_GEN5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (195, 3, 6, 'Gigabyte B860M A ELT WF6E ICE', 589.00, NULL, 12, 0, 'products/motherboard/Gigabyte_B860M_A_ELT_WF6E_ICE.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (196, 3, 6, 'Gigabyte B850 EAGLE WIFI6E', 739.00, 700.00, 12, 0, 'products/motherboard/Gigabyte_B850_EAGLE_WIFI6E.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (197, 3, 6, 'Gigabyte B550 EAGLE', 399.00, NULL, 18, 0, 'products/motherboard/Gigabyte_B550_EAGLE.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (198, 3, 14, 'ASRock B760M-HDV/M.2 D4', 324.00, NULL, 15, 0, 'products/motherboard/ASRock_B760M-HDV_M.2_D4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (199, 3, 14, 'ASRock Z790 Pro RS', 809.00, NULL, 12, 0, 'products/motherboard/ASRock_Z790_Pro_RS.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (200, 3, 14, 'ASRock Z790 Steel Legend WiFi', 999.00, NULL, 12, 0, 'products/motherboard/ASRock_Z790_Steel_Legend_WiFi.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (201, 3, 14, 'ASRock B550M-HDV', 288.00, NULL, 12, 0, 'products/motherboard/ASRock_B550M-HDV.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (202, 3, 14, 'ASRock B550M PRO4', 410.00, NULL, 12, 0, 'products/motherboard/ASRock_B550M_PRO4.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (203, 3, 14, 'ASRock B860M-H2', 399.00, NULL, 12, 0, 'products/motherboard/ASRock_B860M-H2.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (204, 3, 14, 'ASRock B860 Pro-A WiFi', 599.00, NULL, 16, 0, 'products/motherboard/ASRock_B860_Pro-A_WiFi.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (205, 3, 14, 'ASRock B860 LiveMixer WiFi', 799.00, 750.00, 12, 0, 'products/motherboard/ASRock_B860_LiveMixer_WiFi.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (206, 3, 5, 'MSI MAG B860 TOMAHAWK WIFI', 899.00, NULL, 11, 0, 'products/motherboard/MSI_MAG_B860_TOMAHAWK_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (207, 3, 5, 'MSI B860 GAMING PLUS WIFI', 795.00, NULL, 11, 0, 'products/motherboard/MSI_B860_GAMING_PLUS_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (208, 3, 5, 'MSI MAG B850M MORTAR WIFI', 939.00, NULL, 11, 0, 'products/motherboard/MSI_MAG_B850M_MORTAR_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (209, 3, 5, 'MSI PRO B850M-P WIFI', 599.00, 550.00, 11, 0, 'products/motherboard/MSI_PRO_B850M-P_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (210, 3, 5, 'MSI Z790 GAMING PLUS WIFI', 829.00, 800.00, 17, 0, 'products/motherboard/MSI_Z790_GAMING_PLUS_WIFI.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (211, 3, 5, 'MSI MPG B550 GAMING PLUS', 500.00, NULL, 17, 0, 'products/motherboard/MSI_MPG_B550_GAMING_PLUS.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (212, 12, 28, 'ENDORFY Navis F240 ARGB', 319.00, NULL, 7, 0, 'products/cooler/ENDORFY_Navis_F240_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (213, 12, 28, 'ENDORFY Fortis 5 ARGB', 250.00, 229.00, 11, 0, 'products/cooler/ENDORFY_Fortis_5_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (214, 12, 28, 'ENDORFY Fera 5', 129.00, NULL, 11, 0, 'products/cooler/ENDORFY_Fera_5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (215, 12, 28, 'ENDORFY Navis F360 ARGB', 399.00, NULL, 13, 0, 'products/cooler/ENDORFY_Navis_F360_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (216, 12, 28, 'ENDORFY Navis F240', 279.00, NULL, 9, 0, 'products/cooler/ENDORFY_Navis_F240.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (217, 12, 45, 'Thermalright Peerless Vision 360 UB Argb White', 599.00, NULL, 13, 0, 'products/cooler/Thermalright_Peerless_Vision_360_UB_Argb_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (218, 12, 45, 'Thermalright Phantom Spirit 120 SE ARGB', 199.90, NULL, 13, 0, 'products/cooler/Thermalright_Phantom_Spirit_120_SE_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (219, 12, 45, 'Thermalright Assassin X 120 Refined SE ARGB', 99.00, NULL, 13, 0, 'products/cooler/Thermalright_Assassin_X_120_Refined_SE_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (220, 12, 45, 'Thermalright Aqua Elite 360 Black Argb V3', 370.00, NULL, 13, 0, 'products/cooler/Thermalright_Aqua_Elite_360_Black_Argb_V3.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (221, 12, 45, 'Thermalright Peerless Vision 240 Argb Black', 439.00, NULL, 11, 0, 'products/cooler/Thermalright_Peerless_Vision_240_Argb_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (222, 12, 29, 'be quiet! Dark Rock 5', 329.00, NULL, 9, 0, 'products/cooler/be_quiet!_Dark_Rock_5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (223, 12, 29, 'be quiet! Pure Rock Pro 3 LX, czarny', 259.00, NULL, 13, 0, 'products/cooler/be_quiet!_Pure_Rock_Pro_3_LX,_czarny.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (224, 12, 4, 'ASUS ROG STRIX LC III 240 ARGB', 859.00, NULL, 4, 0, 'products/cooler/ASUS_ROG_STRIX_LC_III_240_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (225, 12, 29, 'be quiet! Light Loop 360mm', 649.00, NULL, 13, 0, 'products/cooler/be_quiet!_Light_Loop_360mm.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (226, 12, 29, 'be quiet! Light Loop 240mm', 539.00, NULL, 13, 0, 'products/cooler/be_quiet!_Light_Loop_240mm.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (227, 12, 29, 'be quiet! Pure Rock 3 LX, czarny', 154.99, NULL, 13, 0, 'products/cooler/be_quiet!_Pure_Rock_3_LX,_czarny.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (228, 12, 4, 'ASUS ROG RYUO IV SLC 360 ARGB', 1799.00, NULL, 6, 0, 'products/cooler/ASUS_ROG_RYUO_IV_SLC_360_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (229, 12, 46, 'Krux HydroGlance 360 ARGB LCD', 549.00, NULL, 6, 0, 'products/cooler/Krux_HydroGlance_360_ARGB_LCD.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (230, 12, 47, 'Genesis Hydria 240 ARGB czarne', 287.00, NULL, 6, 0, 'products/cooler/Genesis_Hydria_240_ARGB_czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (231, 12, 47, 'Genesis Hydria 360 ARGB czarne', 368.00, 350.00, 6, 0, 'products/cooler/Genesis_Hydria_360_ARGB_czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (232, 12, 47, 'Genesis Hydria 360 czarne', 315.00, NULL, 6, 0, 'products/cooler/Genesis_Hydria_360_czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (233, 12, 33, 'Cooler Master MasterLiquid 360 Core II ARGB', 339.00, NULL, 12, 0, 'products/cooler/Cooler_Master_MasterLiquid_360_Core_II_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (234, 12, 33, 'Cooler Master MasterLiquid 240 Core II ARGB white', 249.00, NULL, 12, 0, 'products/cooler/Cooler_Master_MasterLiquid_240_Core_II_ARGB_white.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (235, 12, 48, 'Savio Vortex X2 ARGB', 109.90, NULL, 12, 0, 'products/cooler/Savio_Vortex_X2_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (236, 12, 48, 'Noctua NH-D15 chromax.black', 519.00, NULL, 12, 0, 'products/cooler/Noctua_NH-D15_chromax.black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (237, 12, 5, 'MSI MAG CORELIQUID A13 360', 379.00, NULL, 12, 0, 'products/cooler/MSI_MAG_CORELIQUID_A13_360.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (238, 12, 5, 'MSI MAG CORELIQUID A13 240', 289.00, NULL, 12, 0, 'products/cooler/MSI_MAG_CORELIQUID_A13_240.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (239, 12, 5, 'MSI MAG CORELIQUID E240 WHITE', 289.00, NULL, 12, 0, 'products/cooler/MSI_MAG_CORELIQUID_E240_WHITE.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (240, 12, 16, 'NZXT Kraken Plus 360 RGB LCD czarne', 919.00, NULL, 9, 0, 'products/cooler/NZXT_Kraken_Plus_360_RGB_LCD_czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (241, 12, 16, 'NZXT Kraken Elite 280 RGB V2 LCD białe', 829.00, NULL, 9, 0, 'products/cooler/NZXT_Kraken_Elite_280_RGB_V2_LCD_białe.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (242, 7, 28, 'ENDORFY Aquarius 8000 Corona', 599.00, NULL, 7, 0, 'products/case/ENDORFY_Aquarius_8000_Corona.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (243, 7, 49, 'SMX Cassette', 249.00, 149.00, 11, 0, 'products/case/SMX_Cassette.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (244, 7, 49, 'SMX Coffer', 179.00, 129.00, 12, 0, 'products/case/SMX_Coffer.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (245, 7, 49, 'SMX Chest TG', 219.00, NULL, 10, 0, 'products/case/SMX_Chest_TG.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (246, 7, 47, 'Genesis DIAXID 605F Czarna', 328.00, 269.00, 9, 0, 'products/case/Genesis_DIAXID_605F_Czarna.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (247, 7, 49, 'SMX Croft', 259.00, NULL, 13, 0, 'products/case/SMX_Croft.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (248, 7, 31, 'Lian Li DAN A3 Wood Black', 369.00, NULL, 7, 0, 'products/case/Lian_Li_DAN_A3_Wood_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (249, 7, 34, 'Fractal Design Meshify 3 Ambience Pro RGB Black TG Light Tint', 889.00, NULL, 5, 0, 'products/case/Fractal_Design_Meshify_3_Ambience_Pro_RGB_Black_TG_Light_Tint.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (250, 7, 28, 'ENDORFY Arx 700 Air', 449.00, NULL, 6, 0, 'products/case/ENDORFY_Arx_700_Air.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (251, 7, 31, 'Lian Li O11D EVO RGB Black', 739.00, NULL, 4, 0, 'products/case/Lian_Li_O11D_EVO_RGB_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (252, 7, 5, 'MSI MAG PANO 100R PZ', 469.00, 419.00, 8, 0, 'products/case/MSI_MAG_PANO_100R_PZ.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (253, 7, 50, 'Deepcool CC560 ARGB', 239.00, 189.00, 13, 0, 'products/case/Deepcool_CC560_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (254, 7, 49, 'SMX Capsule', 299.00, NULL, 8, 0, 'products/case/SMX_Capsule.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (255, 7, 16, 'NZXT H7 FLOW (2024) White', 459.00, NULL, 5, 0, 'products/case/NZXT_H7_FLOW_(2024)_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (256, 7, 49, 'SMX Pyxis', 329.00, NULL, 6, 0, 'products/case/SMX_Pyxis.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (257, 7, 31, 'Lian Li Lancool 217 Black', 499.00, NULL, 5, 0, 'products/case/Lian_Li_Lancool_217_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (258, 7, 46, 'KRUX Helio', 219.00, 179.00, 14, 0, 'products/case/KRUX_Helio.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (259, 7, 29, 'be quiet! Pure Base 500DX Black', 389.00, NULL, 8, 0, 'products/case/be_quiet!_Pure_Base_500DX_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (260, 7, 46, 'KRUX Vako', 169.00, 139.00, 11, 0, 'products/case/KRUX_Vako.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (261, 7, 28, 'ENDORFY Ventum 200 ARGB', 299.00, NULL, 15, 0, 'products/case/ENDORFY_Ventum_200_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (262, 7, 4, 'ASUS TUF GAMING GT502 HORIZON TG ARGB White', 779.00, NULL, 7, 0, 'products/case/ASUS_TUF_GAMING_GT502_HORIZON_TG_ARGB_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (263, 7, 51, 'DarkFlash DS900W Black', 199.00, NULL, 16, 0, 'products/case/DarkFlash_DS900W_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (264, 7, 51, 'DarkFlash DB330M Mesh White', 139.00, NULL, 15, 0, 'products/case/DarkFlash_DB330M_Mesh_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (265, 7, 51, 'DarkFlash DS900 Mesh Black', 199.00, NULL, 14, 0, 'products/case/DarkFlash_DS900_Mesh_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (266, 7, 51, 'DarkFlash DB330M Mesh Black', 139.00, NULL, 13, 0, 'products/case/DarkFlash_DB330M_Mesh_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (267, 7, 28, 'ENDORFY Regnum 400 ARGB', 449.00, 359.00, 9, 0, 'products/case/ENDORFY_Regnum_400_ARGB.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (269, 7, 51, 'DarkFlash DS900WS + 4 Fans Black', 239.00, NULL, 8, 0, 'products/case/DarkFlash_DS900WS_+_4_Fans_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (270, 7, 16, 'NZXT H9 FLOW (2025) Black', 749.00, NULL, 6, 0, 'products/case/NZXT_H9_FLOW_(2025)_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (271, 7, 29, 'be quiet! Light Base 500', 509.00, NULL, 7, 0, 'products/case/be_quiet!_Light_Base_500.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (272, 7, 29, 'be quiet! PURE BASE 501', 389.00, NULL, 8, 0, 'products/case/be_quiet!_PURE_BASE_501.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (276, 9, 52, 'SteelSeries Apex 3', 264.00, NULL, 10, 0, 'products/keyboard/SteelSeries_Apex_3.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (277, 9, 53, 'Redragon K617 Fizz RGB white/grey', 136.00, NULL, 10, 0, 'products/keyboard/Redragon_K617_Fizz_RGB_white_grey.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (278, 9, 54, 'Dark Project ALU87A Onionite Wired - G3MS Mech. RGB (ENG)', 249.00, 230.00, 8, 0, 'products/keyboard/Dark_Project_ALU87A_Onionite_Wired_-_G3MS_Mech._RGB_(ENG).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (279, 9, 53, 'Redragon K617 Fizz RGB czarna', 130.00, NULL, 6, 0, 'products/keyboard/Redragon_K617_Fizz_RGB_czarna.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (280, 9, 54, 'Dark Project ALU87B Gamma - G3MS Mech. RGB (ENG)', 499.00, 450.00, 12, 0, 'products/keyboard/Dark_Project_ALU87B_Gamma_-_G3MS_Mech._RGB_(ENG).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (281, 9, 52, 'SteelSeries Apex 3 TKL US', 169.00, NULL, 11, 0, 'products/keyboard/SteelSeries_Apex_3_TKL_US.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (282, 9, 55, 'Logitech G213 Prodigy', 189.00, NULL, 13, 0, 'products/keyboard/Logitech_G213_Prodigy.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (283, 9, 56, 'California Access Korero TKL CA1424', 169.00, NULL, 13, 0, 'products/keyboard/California_Access_Korero_TKL_CA1424.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (284, 9, 55, 'Logitech G413 TKL SE', 239.00, NULL, 17, 0, 'products/keyboard/Logitech_G413_TKL_SE.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (285, 9, 55, 'Logitech MK270', 119.00, NULL, 15, 0, 'products/keyboard/Logitech_MK270.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (286, 9, 53, 'Redragon K707WBP-RGB-PRO StarBlade', 169.00, NULL, 15, 0, 'products/keyboard/Redragon_K707WBP-RGB-PRO_StarBlade.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (287, 9, 53, 'Redragon AZURE K652GG-RGB-PRO', 238.00, NULL, 13, 0, 'products/keyboard/Redragon_AZURE_K652GG-RGB-PRO.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (288, 9, 57, 'Tracer GameZone Blade 87', 119.00, NULL, 6, 0, 'products/keyboard/Tracer_GameZone_Blade_87.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (289, 9, 58, 'Accura Artesia ACC-K1408 podświetlana', 69.00, NULL, 13, 0, 'products/keyboard/Accura_Artesia_ACC-K1408_podświetlana.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (290, 9, 58, 'Accura Vista ACC-K1411', 49.00, NULL, 3, 0, 'products/keyboard/Accura_Vista_ACC-K1411.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (291, 9, 58, 'Accura Delano ACC-K1306', 99.00, NULL, 3, 0, 'products/keyboard/Accura_Delano_ACC-K1306.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (292, 9, 46, 'KRUX ATAX 65% Pro RGB Outemu Red', 199.00, 170.00, 16, 0, 'products/keyboard/KRUX_ATAX_65%_Pro_RGB_Outemu_Red.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (293, 9, 46, 'Logitech K400 Plus Czarna', 149.00, NULL, 16, 0, 'products/keyboard/Logitech_K400_Plus_Czarna.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (294, 9, 53, 'Redragon K515-RGB SHIVA 98', 129.00, NULL, 13, 0, 'products/keyboard/Redragon_K515-RGB_SHIVA_98.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (295, 9, 53, 'Redragon K515-RGB SHIVA 98', 129.00, NULL, 13, 0, 'products/keyboard/Redragon_K515-RGB_SHIVA_98.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (296, 9, 47, 'Genesis Thor 230 TKL Anchor Gray Positive RGB Outemu Red', 179.00, NULL, 20, 0, 'products/keyboard/Genesis_Thor_230_TKL_Anchor_Gray_Positive_RGB_Outemu_Red.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (297, 9, 53, 'Redragon K709-RGB NOVA', 149.00, NULL, 20, 0, 'products/keyboard/Redragon_K709-RGB_NOVA.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (298, 9, 59, 'A4Tech Bloody MS76 USB Magnetic Iron Grey', 249.00, 220.00, 20, 0, 'products/keyboard/A4Tech_Bloody_MS76_USB_Magnetic_Iron_Grey.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (299, 9, 52, 'SteelSeries Apex Pro Gen 3 US', 999.00, NULL, 13, 0, 'products/keyboard/SteelSeries_Apex_Pro_Gen_3_US.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (300, 9, 55, 'Logitech MX Keys S Grafitowy', 399.00, 350.00, 13, 0, 'products/keyboard/Logitech_MX_Keys_S_Grafitowy.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (301, 9, 52, 'SteelSeries Apex 3 TKL US Lavender', 169.00, NULL, 13, 0, 'products/keyboard/SteelSeries_Apex_3_TKL_US_Lavender.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (302, 9, 52, 'SteelSeries Apex 9 TKL', 499.00, NULL, 12, 0, 'products/keyboard/SteelSeries_Apex_9_TKL.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (304, 9, 60, 'Razer Huntsman Mini - Mercury Ed. Purple Switch US', 249.00, NULL, 12, 0, 'products/keyboard/Razer_Huntsman_Mini_-_Mercury_Ed._Purple_Switch_US.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (305, 9, 55, 'Logitech G Pro X 60 Lightspeed Biała', 650.00, 600.00, 12, 0, 'products/keyboard/Logitech_G_Pro_X_60_Lightspeed_Biała.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (306, 9, 60, 'Razer Ornata V3 X US', 199.00, NULL, 15, 0, 'products/keyboard/Razer_Ornata_V3_X_US.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (307, 10, 61, 'Glorious GHS Eternal White', 259.00, 250.00, 10, 0, 'products/headphones/Glorious_GHS_Eternal_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (308, 10, 62, 'Sony Inzone H6 AIR Czarny', 799.00, NULL, 20, 0, 'products/headphones/Sony_Inzone_H6_AIR_Czarny.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (309, 10, 63, 'Apple AirPods Max 2 północ', 2500.00, NULL, 12, 0, 'products/headphones/Apple_AirPods_Max_2_północ.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (310, 10, 64, 'HyperX Cloud Jet Wireless Black', 220.00, NULL, 5, 0, 'products/headphones/HyperX_Cloud_Jet_Wireless_Black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (311, 10, 63, 'Apple AirPods Max 2 fioletowy', 2500.00, NULL, 15, 0, 'products/headphones/Apple_AirPods_Max_2_fioletowy.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (313, 10, 55, 'Logitech G PRO X', 369.00, NULL, 13, 0, 'products/headphones/Logitech_G_PRO_X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (314, 10, 62, 'Sony WH-1000XM5SA', 891.00, NULL, 7, 0, 'products/headphones/Sony_WH-1000XM5SA.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (316, 10, 52, 'SteelSeries Arctis Nova 5', 500.00, NULL, 17, 0, 'products/headphones/SteelSeries_Arctis_Nova_5.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (317, 10, 62, 'Sony WH-CH720N Czarne', 320.00, NULL, 11, 0, 'products/headphones/Sony_WH-CH720N_Czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (318, 10, 62, 'Glorious GHS Eternal RGB White', 389.00, NULL, 13, 0, 'products/headphones/Glorious_GHS_Eternal_RGB_White.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (319, 10, 63, 'Apple AirPods Max północ', 2209.00, NULL, 3, 0, 'products/headphones/Apple_AirPods_Max_północ.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (320, 10, 63, 'Redragon VibeCore 600X', 150.00, NULL, 6, 0, 'products/headphones/Redragon_VibeCore_600X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (321, 10, 53, 'Redragon VibeCore 605X', 150.00, NULL, 8, 0, 'products/headphones/Redragon_VibeCore_605X.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (322, 10, 60, 'Razer Barracuda X Chroma Phantom Green', 500.00, NULL, 18, 0, 'products/headphones/Razer_Barracuda_X_Chroma_Phantom_Green.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (323, 10, 60, 'Sony WH-CH520 Czarne', 120.00, NULL, 4, 0, 'products/headphones/Sony_WH-CH520_Czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (324, 10, 65, 'JBL Tune 520C USB-C fioletowe', 110.00, NULL, 10, 0, 'products/headphones/JBL_Tune_520C_USB-C_fioletowe.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (325, 10, 65, 'JBL Tune 520C USB-C niebieskie', 110.00, NULL, 10, 0, 'products/headphones/JBL_Tune_520C_USB-C_niebieskie.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (326, 10, 65, 'JBL Tune 520C USB-C białe', 110.00, NULL, 10, 0, 'products/headphones/JBL_Tune_520C_USB-C_białe.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (327, 10, 65, 'JBL Tour One M3 ANC Czarne', 1099.00, NULL, 13, 0, 'products/headphones/JBL_Tour_One_M3_ANC_Czarne.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (329, 10, 64, 'HyperX CloudX Stinger Core Wireless', 400.00, NULL, 5, 0, 'products/headphones/HyperX_CloudX_Stinger_Core_Wireless.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (330, 10, 63, 'Apple AirPods Max księżycowa poświata', 2220.00, NULL, 15, 0, 'products/headphones/Apple_AirPods_Max_księżycowa_poświata.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (331, 8, 64, 'HyperX Pulsefire Haste 2 (czarny)', 140.00, NULL, 10, 0, 'products/mouse/HyperX_Pulsefire_Haste_2_(czarny).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (332, 8, 55, 'Logitech LIFT Grafitowa', 220.00, NULL, 15, 0, 'products/mouse/Logitech_LIFT_Grafitowa.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (333, 8, 64, 'HyperX Pulsefire Fuse Wireless', 150.00, NULL, 17, 0, 'products/mouse/HyperX_Pulsefire_Fuse_Wireless.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (334, 8, 64, 'HyperX Pulsefire Haste 2 Wireless (biały)', 200.00, NULL, 20, 0, 'products/mouse/HyperX_Pulsefire_Haste_2_Wireless_(biały).jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (335, 8, 55, 'Logitech G102 LIGHTSYNC czarna', 110.00, NULL, 4, 0, 'products/mouse/Logitech_G102_LIGHTSYNC_czarna.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (336, 8, 55, 'Logitech M705 Marathon', 140.01, NULL, 14, 0, 'products/mouse/Logitech_M705_Marathon.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (337, 8, 55, 'Logitech M705 Marathon', 140.01, NULL, 9, 0, 'products/mouse/Logitech_M705_Marathon.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (338, 8, 60, 'Razer Basilisk V3', 190.00, NULL, 19, 0, 'products/mouse/Razer_Basilisk_V3.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (339, 8, 60, 'Razer DeathAdder V3', 230.00, NULL, 9, 0, 'products/mouse/Razer_DeathAdder_V3.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (340, 8, 55, 'Logitech G305 Lightspeed czarna', 230.00, NULL, 6, 0, 'products/mouse/Logitech_G305_Lightspeed_czarna.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (341, 8, 55, 'Logitech MX Anywhere 3S Grafit', 330.00, NULL, 16, 0, 'products/mouse/Logitech_MX_Anywhere_3S_Grafit.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (342, 8, 66, 'Silver Monkey M40 Wireless Comfort Mouse Black Silent', 65.00, NULL, 10, 0, 'products/mouse/Silver_Monkey_M40_Wireless_Comfort_Mouse_Black_Silent.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (343, 8, 55, 'Logitech G PRO X Superlight 2 czarny', 560.00, NULL, 14, 0, 'products/mouse/Logitech_G_PRO_X_Superlight_2_czarny.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (344, 8, 22, 'SMX Mysz gamingowa Bonobo black', 378.00, NULL, 7, 0, 'products/mouse/SMX_Mysz_gamingowa_Bonobo_black.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (345, 8, 28, 'ENDORFY Lix Plus', 200.00, NULL, 17, 0, 'products/mouse/ENDORFY_Lix_Plus.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (346, 8, 60, 'Razer Basilisk V3 X HyperSpeed', 220.00, NULL, 16, 0, 'products/mouse/Razer_Basilisk_V3_X_HyperSpeed.jpg');
INSERT INTO public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) VALUES (347, 8, 60, 'Razer Basilisk V3 X HyperSpeed', 220.00, NULL, 16, 0, 'products/mouse/Razer_Basilisk_V3_X_HyperSpeed.jpg');


--
-- TOC entry 3986 (class 0 OID 17604)
-- Dependencies: 399
-- Data for Name: cart_items; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4007 (class 0 OID 20158)
-- Dependencies: 420
-- Data for Name: category_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (48, 1, 7, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (49, 1, 38, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (50, 12, 39, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (1, 1, 1, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (7, 2, 8, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (8, 2, 9, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (9, 2, 10, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (10, 3, 1, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (11, 3, 11, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (12, 3, 12, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (13, 3, 13, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (14, 4, 13, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (15, 4, 14, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (16, 4, 15, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (17, 4, 16, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (18, 5, 17, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (19, 5, 18, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (20, 5, 19, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (21, 6, 20, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (22, 6, 21, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (23, 6, 22, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (24, 7, 23, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (25, 7, 24, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (26, 7, 25, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (27, 7, 12, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (28, 8, 26, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (29, 8, 27, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (30, 9, 26, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (31, 9, 28, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (32, 10, 26, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (33, 10, 29, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (34, 11, 29, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (36, 12, 30, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (38, 13, 32, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (39, 13, 33, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (40, 14, 34, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (41, 14, 35, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (42, 14, 36, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (43, 14, 37, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (2, 1, 2, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (3, 1, 3, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (4, 1, 4, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (5, 1, 5, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (6, 1, 6, false);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (44, 2, 40, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (45, 3, 43, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (46, 3, 44, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (47, 1, 42, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (54, 12, 41, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (56, 4, 45, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (55, 6, 46, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (51, 6, 47, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (52, 2, 46, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (53, 3, 47, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (57, 3, 48, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (58, 12, 49, true);
INSERT INTO public.category_attributes (id, category_id, attribute_id, is_required) VALUES (59, 7, 50, true);



--
-- TOC entry 3991 (class 0 OID 17649)
-- Dependencies: 404
-- Data for Name: shipping_methods; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3993 (class 0 OID 17656)
-- Dependencies: 406
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3997 (class 0 OID 17696)
-- Dependencies: 410
-- Data for Name: complaints; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 3995 (class 0 OID 17679)
-- Dependencies: 408
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4005 (class 0 OID 20134)
-- Dependencies: 418
-- Data for Name: product_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1, 1, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (2, 1, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (37, 14, 8, 213);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (40, 15, 8, 213);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (133, 37, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (166, 44, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (9, 2, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (10, 2, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (488, 142, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (490, 143, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (16, 3, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (17, 3, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (828, 224, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (829, 225, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (830, 226, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (831, 227, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (23, 4, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (832, 228, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (833, 229, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (834, 230, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (835, 231, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (24, 4, 2, 10);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (30, 5, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (31, 5, 2, 10);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (836, 232, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (837, 233, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (838, 234, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (839, 235, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (38, 14, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (39, 14, 10, 22);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (41, 15, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (42, 15, 10, 22);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (43, 16, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (45, 16, 19, 43);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (840, 236, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (46, 17, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (7, 1, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (48, 17, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (49, 18, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (15, 2, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (51, 18, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (52, 19, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (22, 3, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (54, 19, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (55, 20, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (29, 4, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (57, 20, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (58, 21, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (36, 5, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (60, 21, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (61, 22, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (80, 26, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (63, 22, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (64, 23, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (87, 27, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (98, 29, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (68, 24, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (105, 30, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (70, 24, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (71, 25, 17, 41);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (128, 35, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (73, 25, 19, 45);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (142, 38, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (74, 26, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (75, 26, 2, 16);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (156, 41, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (81, 27, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (82, 27, 2, 16);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (88, 28, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (92, 29, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (93, 29, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (99, 30, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (106, 31, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (110, 32, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (114, 33, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (118, 34, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (122, 35, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (123, 35, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (129, 36, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (134, 37, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (135, 37, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (136, 38, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (137, 38, 2, 10);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (100, 30, 2, 10);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (143, 39, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (147, 40, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (151, 41, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (152, 41, 2, 14);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (157, 42, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (161, 43, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (167, 44, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (168, 44, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (170, 45, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (171, 45, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (173, 46, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (174, 46, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (176, 47, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (177, 47, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (179, 48, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (180, 48, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (182, 49, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (183, 49, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (185, 50, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (186, 50, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (188, 51, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (189, 51, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (191, 52, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (192, 52, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (194, 53, 9, 57);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (195, 53, 10, 25);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (197, 54, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (198, 54, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (200, 55, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (201, 55, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (203, 56, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (204, 56, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (206, 57, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (207, 57, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (209, 58, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (210, 58, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (212, 59, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (213, 59, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (215, 60, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (216, 60, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (218, 61, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (219, 61, 10, 23);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (221, 62, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (222, 62, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (224, 63, 9, 56);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (225, 63, 10, 24);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (227, 64, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (228, 64, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (230, 65, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (231, 65, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (233, 66, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (234, 66, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (236, 67, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (237, 67, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (239, 68, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (240, 68, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (242, 69, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (243, 69, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (245, 70, 9, 55);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (246, 70, 10, 21);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (247, 71, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (169, 45, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (172, 46, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (175, 47, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (251, 72, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (178, 48, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (181, 49, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (184, 50, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (187, 51, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (190, 52, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (259, 74, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (193, 53, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (196, 54, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (199, 55, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (263, 75, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (202, 56, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (205, 57, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (208, 58, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (267, 76, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (211, 59, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (214, 60, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (217, 61, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (271, 77, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (220, 62, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (223, 63, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (226, 64, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (275, 78, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (229, 65, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (232, 66, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (235, 67, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (279, 80, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (238, 68, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (241, 69, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (244, 70, 8, 232);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (255, 73, 34, 233);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (257, 73, 36, 217);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (287, 82, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (283, 81, 34, 233);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (285, 81, 36, 217);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (327, 92, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (291, 83, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (329, 92, 36, 217);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (295, 84, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (299, 85, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (303, 86, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (307, 87, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (311, 88, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (315, 89, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (319, 90, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (323, 91, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (331, 93, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (335, 94, 34, 210);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (337, 94, 36, 218);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (339, 95, 34, 224);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (341, 95, 36, 207);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (343, 96, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (345, 96, 36, 218);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (347, 97, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (349, 97, 36, 218);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (351, 98, 34, 233);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (353, 98, 36, 225);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (355, 99, 34, 233);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (357, 99, 36, 225);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (359, 100, 34, 210);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (361, 100, 36, 212);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (363, 101, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (365, 101, 36, 215);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (367, 102, 34, 210);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (369, 102, 36, 216);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (371, 103, 34, 224);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (373, 103, 36, 236);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (375, 104, 34, 210);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (377, 104, 36, 235);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (379, 105, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (381, 105, 36, 215);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (383, 106, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (385, 106, 36, 244);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (387, 107, 34, 237);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (389, 107, 36, 244);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (391, 108, 34, 224);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (393, 108, 36, 216);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (398, 110, 34, 219);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (400, 110, 36, 216);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (402, 111, 34, 238);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (404, 111, 36, 225);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (413, 114, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (424, 118, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (407, 112, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (408, 112, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (438, 123, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (410, 113, 21, 49);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (411, 113, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (415, 115, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (416, 115, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (446, 126, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (418, 116, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (419, 116, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (421, 117, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (422, 117, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (451, 128, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (426, 119, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (427, 119, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (429, 120, 21, 50);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (430, 120, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (465, 133, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (432, 121, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (433, 121, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (435, 122, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (436, 122, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (470, 135, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (440, 124, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (441, 124, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (443, 125, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (444, 125, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (483, 140, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (448, 127, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (449, 127, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (630, 176, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (453, 129, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (454, 129, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (631, 26, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (456, 130, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (457, 130, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (633, 29, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (459, 131, 21, 50);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (460, 131, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (462, 132, 21, 49);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (463, 132, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (467, 134, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (468, 134, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (472, 136, 21, 50);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (473, 136, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (480, 139, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (481, 139, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (485, 141, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (486, 141, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (492, 144, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (493, 144, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (11, 2, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (499, 147, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (500, 147, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (495, 145, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (502, 148, 21, 50);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (503, 148, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (505, 149, 21, 49);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (506, 149, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (497, 146, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (508, 150, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (509, 150, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (511, 151, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (512, 151, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (520, 154, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (514, 152, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (515, 152, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (517, 153, 21, 48);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (518, 153, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (522, 155, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (538, 163, 21, 46);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (539, 163, 22, 51);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (540, 164, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (541, 164, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (524, 156, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (526, 157, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (547, 165, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (548, 165, 2, 10);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (528, 158, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (530, 159, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (554, 166, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (555, 166, 2, 11);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (532, 160, 33, 230);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (534, 161, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (561, 167, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (562, 167, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (536, 162, 33, 223);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (546, 164, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (553, 165, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (568, 168, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (569, 168, 2, 10);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (560, 166, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (567, 167, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (574, 168, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (581, 169, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (575, 169, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (576, 169, 2, 15);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (588, 170, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (595, 171, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (602, 172, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (609, 173, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (582, 170, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (583, 170, 2, 15);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (616, 174, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (623, 175, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (635, 35, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (636, 38, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (589, 171, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (590, 171, 2, 13);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (639, 3, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (640, 5, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (641, 4, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (642, 41, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (596, 172, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (597, 172, 2, 17);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (643, 164, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (644, 166, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (645, 165, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (646, 167, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (603, 173, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (604, 173, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (647, 168, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (648, 169, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (649, 170, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (651, 172, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (610, 174, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (611, 174, 2, 9);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (654, 175, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (662, 177, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (663, 177, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (670, 178, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (617, 175, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (618, 175, 2, 13);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (671, 178, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (624, 176, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (625, 176, 2, 16);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (656, 177, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (657, 177, 2, 16);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (664, 178, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (665, 178, 2, 13);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (672, 179, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (673, 179, 2, 13);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (816, 212, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (817, 213, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (818, 214, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (819, 215, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (680, 180, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (681, 180, 2, 14);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (820, 216, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (821, 217, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (822, 218, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (823, 219, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (688, 181, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (689, 181, 2, 18);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (824, 220, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (825, 221, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (826, 222, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (827, 223, 30, 226);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (696, 182, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (697, 182, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (698, 182, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (699, 182, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (700, 183, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (701, 183, 11, 59);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (702, 183, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (703, 183, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (704, 184, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (705, 184, 11, 59);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (706, 184, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (707, 184, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (708, 185, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (709, 185, 11, 31);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (710, 185, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (711, 185, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (712, 186, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (713, 186, 11, 27);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (714, 186, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (715, 186, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (716, 187, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (717, 187, 11, 29);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (718, 187, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (719, 187, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (720, 188, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (721, 188, 11, 32);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (722, 188, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (723, 188, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (724, 189, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (725, 189, 11, 29);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (726, 189, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (727, 189, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (728, 190, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (729, 190, 11, 27);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (730, 190, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (731, 190, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (732, 191, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (733, 191, 11, 31);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (734, 191, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (735, 191, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (736, 192, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (737, 192, 11, 29);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (738, 192, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (739, 192, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (740, 193, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (741, 193, 11, 29);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (742, 193, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (743, 193, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (744, 194, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (745, 194, 11, 31);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (746, 194, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (747, 194, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (748, 195, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (749, 195, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (750, 195, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (751, 195, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (752, 196, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (753, 196, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (754, 196, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (755, 196, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (756, 197, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (757, 197, 11, 27);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (758, 197, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (759, 197, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (760, 198, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (761, 198, 11, 31);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (762, 198, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (763, 198, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (764, 199, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (765, 199, 11, 32);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (766, 199, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (767, 199, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (768, 200, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (769, 200, 11, 32);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (770, 200, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (771, 200, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (772, 201, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (773, 201, 11, 27);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (774, 201, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (775, 201, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (776, 202, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (777, 202, 11, 27);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (778, 202, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (779, 202, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (780, 203, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (781, 203, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (782, 203, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (783, 203, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (784, 204, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (785, 204, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (786, 204, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (787, 204, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (788, 205, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (789, 205, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (790, 205, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (791, 205, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (792, 206, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (793, 206, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (794, 206, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (795, 206, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (796, 207, 1, 5);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (797, 207, 11, 58);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (798, 207, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (799, 207, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (800, 208, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (801, 208, 11, 59);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (802, 208, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (803, 208, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (804, 209, 1, 2);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (805, 209, 11, 59);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (806, 209, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (807, 209, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (808, 210, 1, 4);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (809, 210, 11, 32);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (810, 210, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (811, 210, 13, 38);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (812, 211, 1, 1);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (813, 211, 11, 27);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (814, 211, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (815, 211, 13, 37);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (678, 179, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (679, 179, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (686, 180, 7, 202);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (687, 180, 38, 203);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (694, 181, 7, 204);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (632, 27, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (634, 30, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (637, 1, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (638, 2, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (650, 171, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (652, 173, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (653, 174, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (655, 176, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (695, 181, 38, 205);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (3, 1, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (861, 237, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (862, 238, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (863, 239, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (864, 240, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (865, 241, 30, 242);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (876, 242, 23, 206);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (880, 243, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (884, 244, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (888, 245, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (892, 246, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (896, 247, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (900, 248, 23, 228);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (904, 249, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (908, 250, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (912, 251, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (916, 252, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (920, 253, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (924, 254, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (928, 255, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (932, 256, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (936, 257, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (940, 258, 23, 228);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (944, 259, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (948, 260, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (952, 261, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (956, 262, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (960, 263, 23, 206);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (964, 264, 23, 228);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (968, 265, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (879, 242, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (972, 266, 23, 228);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (976, 267, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (883, 243, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (984, 269, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (988, 270, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (887, 244, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (992, 271, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (996, 272, 23, 208);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (891, 245, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (895, 246, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (899, 247, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (903, 248, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (907, 249, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (911, 250, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (915, 251, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (919, 252, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (923, 253, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (927, 254, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (931, 255, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (935, 256, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (939, 257, 12, 35);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (943, 258, 12, 35);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (947, 259, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (951, 260, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (955, 261, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (959, 262, 12, 35);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (963, 263, 12, 35);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (967, 264, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (971, 265, 12, 35);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (975, 266, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (979, 267, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (987, 269, 12, 33);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (991, 270, 12, 36);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (995, 271, 12, 35);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (999, 272, 12, 34);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (4, 1, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (5, 1, 5, 140);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (6, 1, 6, 185);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (12, 2, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (13, 2, 5, 144);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (14, 2, 6, 87);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (18, 3, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (19, 3, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (20, 3, 5, 183);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (21, 3, 6, 63);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (25, 4, 3, 98);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (26, 4, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (27, 4, 5, 97);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (28, 4, 6, 72);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (32, 5, 3, 98);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (33, 5, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (34, 5, 5, 102);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (35, 5, 6, 63);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (44, 16, 18, 75);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (47, 17, 18, 148);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (50, 18, 18, 187);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (53, 19, 18, 132);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (56, 20, 18, 148);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (59, 21, 18, 187);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (62, 22, 18, 132);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (66, 23, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (67, 23, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (69, 24, 18, 62);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (72, 25, 18, 93);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (65, 23, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (76, 26, 3, 191);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (77, 26, 4, 177);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (79, 26, 6, 184);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (83, 27, 3, 74);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (84, 27, 4, 165);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (85, 27, 5, 77);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (86, 27, 6, 194);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (90, 28, 15, 113);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (91, 28, 16, 111);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (96, 29, 5, 90);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (97, 29, 6, 107);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (104, 30, 6, 131);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (107, 31, 14, 193);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (108, 31, 15, 96);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (109, 31, 16, 159);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (112, 32, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (113, 32, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (116, 33, 15, 170);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (117, 33, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (120, 34, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (121, 34, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (126, 35, 5, 134);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (127, 35, 6, 61);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (131, 36, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (132, 36, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (140, 38, 5, 90);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (141, 38, 6, 184);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (145, 39, 15, 96);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (146, 39, 16, 159);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (149, 40, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (150, 40, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (153, 41, 4, 100);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (155, 41, 6, 67);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (159, 42, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (160, 42, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (163, 43, 15, 96);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (164, 43, 16, 159);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (165, 41, 3, 114);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (249, 71, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (250, 71, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (253, 72, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (254, 72, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (256, 73, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (258, 73, 37, 71);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (260, 74, 14, 193);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (261, 74, 15, 170);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (262, 74, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (264, 75, 14, 99);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (265, 75, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (266, 75, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (269, 76, 15, 139);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (270, 76, 16, 156);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (273, 77, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (274, 77, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (277, 78, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (278, 78, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (281, 80, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (282, 80, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (284, 81, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (286, 81, 37, 71);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (288, 82, 14, 99);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (289, 82, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (290, 82, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (293, 83, 15, 96);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (294, 83, 16, 130);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (296, 84, 14, 193);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (297, 84, 15, 139);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (298, 84, 16, 159);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (301, 85, 15, 139);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (302, 85, 16, 159);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (305, 86, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (306, 86, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (309, 87, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (310, 87, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (312, 88, 14, 193);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (313, 88, 15, 170);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (314, 88, 16, 198);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (316, 89, 14, 193);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (318, 89, 16, 161);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (321, 90, 15, 170);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (322, 90, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (325, 91, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (326, 91, 16, 89);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (328, 92, 35, 126);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (330, 92, 37, 92);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (332, 93, 14, 99);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (333, 93, 15, 78);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (334, 93, 16, 186);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (336, 94, 35, 151);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (338, 94, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (340, 95, 35, 151);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (342, 95, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (344, 96, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (346, 96, 37, 82);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (348, 97, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (350, 97, 37, 82);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (352, 98, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (354, 98, 37, 71);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (356, 99, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (358, 99, 37, 71);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (360, 100, 35, 151);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (362, 100, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (364, 101, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (366, 101, 37, 92);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (368, 102, 35, 146);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (370, 102, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (317, 89, 15, 139);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (372, 103, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (374, 103, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (376, 104, 35, 73);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (378, 104, 37, 197);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (380, 105, 35, 145);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (382, 105, 37, 82);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (384, 106, 35, 126);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (386, 106, 37, 92);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (388, 107, 35, 126);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (390, 107, 37, 92);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (392, 108, 35, 146);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (394, 108, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (399, 110, 35, 151);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (401, 110, 37, 190);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (403, 111, 35, 86);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (405, 111, 37, 149);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (406, 112, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (409, 113, 20, 201);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (414, 115, 20, 201);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (417, 116, 20, 108);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (420, 117, 20, 108);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (425, 119, 20, 108);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (428, 120, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (431, 121, 20, 196);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (434, 122, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (439, 124, 20, 64);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (442, 125, 20, 108);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (447, 127, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (452, 129, 20, 181);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (455, 130, 20, 64);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (458, 131, 20, 201);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (461, 132, 20, 201);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (466, 134, 20, 196);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (471, 136, 20, 189);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (479, 139, 20, 201);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (484, 141, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (491, 144, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (498, 147, 20, 108);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (501, 148, 20, 129);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (504, 149, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (507, 150, 20, 64);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (510, 151, 20, 196);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (513, 152, 20, 108);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (516, 153, 20, 81);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (537, 163, 20, 196);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (544, 164, 5, 133);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (545, 164, 6, 167);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (552, 165, 6, 122);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (556, 166, 3, 136);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (557, 166, 4, 66);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (558, 166, 5, 70);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (559, 166, 6, 166);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (565, 167, 5, 109);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (566, 167, 6, 103);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (572, 168, 5, 90);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (573, 168, 6, 67);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (577, 169, 3, 153);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (578, 169, 4, 66);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (579, 169, 5, 115);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (580, 169, 6, 195);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (584, 170, 3, 153);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (585, 170, 4, 66);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (586, 170, 5, 115);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (587, 170, 6, 195);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (593, 171, 5, 119);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (599, 172, 4, 100);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (600, 172, 5, 77);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (601, 172, 6, 122);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (607, 173, 5, 134);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (615, 174, 6, 61);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (619, 175, 3, 74);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (621, 175, 5, 119);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (626, 176, 3, 74);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (627, 176, 4, 165);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (628, 176, 5, 77);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (629, 176, 6, 194);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (658, 177, 3, 158);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (659, 177, 4, 163);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (660, 177, 5, 134);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (661, 177, 6, 184);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (666, 178, 3, 191);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (667, 178, 4, 100);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (669, 178, 6, 107);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (674, 179, 3, 74);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (677, 179, 6, 194);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (682, 180, 3, 160);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (683, 180, 4, 100);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (685, 180, 6, 61);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (690, 181, 3, 153);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (691, 181, 4, 137);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (692, 181, 5, 119);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (693, 181, 6, 67);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (841, 212, 39, 106);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (842, 213, 39, 147);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (843, 214, 39, 179);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (844, 215, 39, 182);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (845, 216, 39, 65);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (846, 217, 39, 182);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (847, 218, 39, 171);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (848, 219, 39, 164);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (849, 220, 39, 125);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (850, 221, 39, 65);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (851, 222, 39, 105);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (852, 223, 39, 171);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (853, 225, 39, 125);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (854, 226, 39, 65);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (855, 227, 39, 179);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (856, 224, 39, 65);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (857, 228, 39, 182);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (858, 229, 39, 125);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (859, 230, 39, 200);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (860, 231, 39, 125);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (866, 232, 39, 125);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (867, 233, 39, 182);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (868, 234, 39, 65);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (869, 235, 39, 179);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (870, 236, 39, 105);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (871, 237, 39, 182);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (872, 238, 39, 65);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (873, 239, 39, 200);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (874, 240, 39, 182);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (875, 241, 39, 125);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (877, 242, 24, 117);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (878, 242, 25, 80);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (881, 243, 24, 84);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (882, 243, 25, 135);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (885, 244, 24, 192);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (886, 244, 25, 174);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (889, 245, 24, 112);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (890, 245, 25, 142);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (893, 246, 24, 150);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (894, 246, 25, 104);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (897, 247, 24, 124);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (898, 247, 25, 121);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (901, 248, 24, 176);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (902, 248, 25, 142);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (905, 249, 24, 152);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (906, 249, 25, 174);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (909, 250, 24, 168);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (910, 250, 25, 80);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (913, 251, 24, 180);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (914, 251, 25, 121);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (917, 252, 24, 180);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (918, 252, 25, 120);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (921, 253, 24, 112);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (922, 253, 25, 123);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (925, 254, 24, 154);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (926, 254, 25, 172);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (929, 255, 24, 168);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (930, 255, 25, 121);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (933, 256, 24, 168);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (934, 256, 25, 172);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (937, 257, 24, 180);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (938, 257, 25, 172);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (941, 258, 24, 192);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (942, 258, 25, 174);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (945, 259, 24, 157);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (946, 259, 25, 116);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (949, 260, 24, 69);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (950, 260, 25, 88);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (953, 261, 24, 68);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (954, 261, 25, 76);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (957, 262, 24, 124);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (958, 262, 25, 123);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (961, 263, 24, 143);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (962, 263, 25, 199);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (965, 264, 24, 60);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (966, 264, 25, 172);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (969, 265, 24, 143);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (970, 265, 25, 199);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (973, 266, 24, 60);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (974, 266, 25, 172);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (977, 267, 24, 112);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (978, 267, 25, 85);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (985, 269, 24, 143);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (986, 269, 25, 199);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (989, 270, 24, 101);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (990, 270, 25, 142);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (993, 271, 24, 124);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (994, 271, 25, 121);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (997, 272, 24, 79);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (998, 272, 25, 135);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (89, 28, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (111, 32, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (115, 33, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (119, 34, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (130, 36, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (144, 39, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (148, 40, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (158, 42, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (162, 43, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (248, 71, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (252, 72, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (268, 76, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (272, 77, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (276, 78, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (280, 80, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (292, 83, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (300, 85, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (304, 86, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (308, 87, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (320, 90, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (324, 91, 14, 173);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (125, 35, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (139, 38, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (550, 165, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (571, 168, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (620, 175, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (675, 179, 4, 83);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (103, 30, 5, 102);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (551, 165, 5, 102);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (154, 41, 5, 97);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (614, 174, 5, 140);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (668, 178, 5, 140);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (676, 179, 5, 183);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (594, 171, 6, 185);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (95, 29, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (102, 30, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (543, 164, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (564, 167, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (592, 171, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (606, 173, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (613, 174, 4, 178);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (124, 35, 3, 98);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (138, 38, 3, 98);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (549, 165, 3, 98);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (570, 168, 3, 98);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (78, 26, 5, 144);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (684, 180, 5, 144);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (608, 173, 6, 63);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (622, 175, 6, 63);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (94, 29, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (101, 30, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (542, 164, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (563, 167, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (591, 171, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (605, 173, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (612, 174, 3, 91);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (598, 172, 3, 114);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1002, 276, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1003, 276, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1004, 277, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1005, 277, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1006, 278, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1007, 278, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1008, 279, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1009, 279, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1010, 280, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1011, 280, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1012, 281, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1013, 281, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1014, 282, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1015, 282, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1016, 283, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1017, 283, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1018, 284, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1019, 284, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1020, 285, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1021, 285, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1022, 286, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1023, 286, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1024, 287, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1025, 287, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1026, 288, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1027, 288, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1028, 289, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1029, 289, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1030, 290, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1031, 290, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1032, 291, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1033, 291, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1034, 292, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1035, 292, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1036, 293, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1037, 293, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1038, 294, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1039, 295, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1040, 295, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1041, 296, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1042, 296, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1043, 297, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1044, 297, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1045, 298, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1046, 298, 28, 251);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1047, 299, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1048, 299, 28, 249);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1049, 300, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1050, 300, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1051, 301, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1052, 301, 28, 248);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1053, 302, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1054, 302, 28, 252);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1057, 304, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1058, 304, 28, 252);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1059, 305, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1060, 305, 28, 252);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1061, 306, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1062, 306, 28, 251);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1063, 307, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1064, 307, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1065, 308, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1066, 308, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1067, 309, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1068, 309, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1069, 310, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1070, 310, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1071, 311, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1072, 311, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1075, 313, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1076, 313, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1077, 314, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1078, 314, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1081, 316, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1082, 316, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1083, 317, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1084, 317, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1085, 318, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1086, 318, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1087, 319, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1088, 319, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1089, 320, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1090, 320, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1091, 321, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1092, 321, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1093, 322, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1094, 322, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1095, 323, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1096, 323, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1097, 324, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1098, 324, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1099, 325, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1100, 325, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1101, 326, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1102, 326, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1103, 327, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1104, 327, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1107, 329, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1108, 329, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1109, 330, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1110, 330, 29, 254);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1111, 331, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1112, 331, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1113, 332, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1114, 332, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1115, 333, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1116, 333, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1117, 334, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1118, 334, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1119, 335, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1120, 335, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1121, 336, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1122, 336, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1123, 337, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1124, 337, 27, 261);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1125, 338, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1126, 338, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1127, 339, 26, 247);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1128, 339, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1129, 340, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1130, 340, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1131, 341, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1132, 341, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1133, 342, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1134, 342, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1135, 343, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1136, 343, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1137, 344, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1138, 344, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1139, 345, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1140, 345, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1141, 346, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1142, 346, 27, 255);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1143, 347, 26, 250);
INSERT INTO public.product_attributes (id, product_id, attribute_category_id, attribute_value_id) VALUES (1144, 347, 27, 255);
SELECT setval('product_attributes_id_seq', (SELECT MAX(id) FROM product_attributes));
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (114, 32, 303); -- Wi-Fi 6E
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (114, 32, 306); -- Bluetooth 5.2

-- Produkt 118 (Stare ID 243: Wi-Fi 5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (118, 32, 301);

-- Produkt 123 (Stare ID 214: LAN)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (123, 32, 309);

-- Produkt 126 (Stare ID 227: Wi-Fi 7)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (126, 32, 304);

-- Produkt 128 (Stare ID 211: Wi-Fi 7, Bluetooth 5.4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (128, 32, 304); -- Wi-Fi 7
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (128, 32, 308); -- Bluetooth 5.4

-- Produkt 133 (Stare ID 209: Pełna lista IEEE 802.1/802.3)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (133, 32, 310); -- 802.1 p
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (133, 32, 311); -- 802.1 q
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (133, 32, 312); -- 802.3
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (133, 32, 313); -- 802.3 ab
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (133, 32, 314); -- 802.3 u
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (133, 32, 315); -- 802.3 x

-- Produkt 135 (Stare ID 241: Wi-Fi 6, Bluetooth 5.0)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (135, 32, 302); -- Wi-Fi 6
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (135, 32, 305); -- Bluetooth 5.0

-- Produkt 140 (Stare ID 234: Rozszerzona lista IEEE 802.3)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 312); -- 802.3
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 313); -- 802.3 ab
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 316); -- 802.3 an
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 317); -- 802.3 az
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 318); -- 802.3 bz
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 314); -- 802.3 u
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (140, 32, 315); -- 802.3 x

-- Produkt 142 (Stare ID 231: Wi-Fi 6, Bluetooth 5.3)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (142, 32, 302); -- Wi-Fi 6
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (142, 32, 307); -- Bluetooth 5.3

-- Produkt 143 (Stare ID 243: Wi-Fi 5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (143, 32, 301);

-- Produkt 145 (Stare ID 229: Wi-Fi 6, Bluetooth 5.2)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (145, 32, 302); -- Wi-Fi 6
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (145, 32, 306); -- Bluetooth 5.2

-- Produkt 146 (Stare ID 222: Wi-Fi 4, 5, 6)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (146, 32, 300); -- Wi-Fi 4
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (146, 32, 301); -- Wi-Fi 5
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (146, 32, 302); -- Wi-Fi 6

-- Produkt 154 (Stare ID 243: Wi-Fi 5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (154, 32, 301);

-- Produkt 155 (Stare ID 221: Wi-Fi 6)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (155, 32, 302);

-- Produkt 156 (Stare ID 243: Wi-Fi 5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (156, 32, 301);

-- Produkty 157, 160, 161, 162 (Stare ID 220: Wi-Fi 4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (157, 32, 300);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (160, 32, 300);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (161, 32, 300);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (162, 32, 300);

-- Produkt 158 (Stare ID 211: Wi-Fi 7, Bluetooth 5.4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (158, 32, 304); -- Wi-Fi 7
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (158, 32, 308); -- Bluetooth 5.4

-- Produkt 159 (Stare ID 245: IEEE 802.3 bz itd.)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (159, 32, 312); -- 802.3
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (159, 32, 313); -- 802.3 ab
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (159, 32, 318); -- 802.3 bz
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (159, 32, 314); -- 802.3 u
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (159, 32, 315); -- 802.3 x

-- Przypisanie długości do konkretnych kart
-- ID 14: ASRock Rx 6700 XT Challenger (269mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (14, 40, 320);

-- ID 15: ASRock Rx 6600 Challenger (269mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (15, 40, 320);

-- ID 37: Gigabyte RX 9060 XT Gaming OC (282mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (37, 40, 321);

-- ID 44: MSI RTX 5060 Ventus 2X (225mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (44, 40, 322);

-- ID 47: ASUS RTX 5070 Dual (267mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (47, 40, 323);

-- ID 48: MSI RTX 5070 Ti Gaming Trio (337mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (48, 40, 324);

-- ID 49: Gigabyte RTX 5080 Windforce (300mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (49, 40, 325);

-- ID 51: INNO3D RTX 5080 X3 (297mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (51, 40, 326);

-- ID 52: Zotac RTX 5060 Twin Edge (225mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (52, 40, 322);

-- ID 54: Sapphire RX 9060 XT Pure (320mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (54, 40, 328);

-- ID 62: Zotac RTX 5050 Low Profile (182mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (62, 40, 327);

-- ID 66: ASUS RTX 5070 Ti ROG Strix (337mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (66, 40, 324);

-- ID 69: Gigabyte RTX 5060 Aero OC (300mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (69, 40, 325);

-- ID 45: Zotac RTX 5070 Ti Solid SFF (304mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (45, 40, 330);

-- ID 46: Gigabyte RX 9070 XT Gaming OC (288mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (46, 40, 331);

-- ID 50: ASUS RTX 5080 Prime OC (304mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (50, 40, 330);

-- ID 53: Intel Arc Pro B50 (167mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (53, 40, 329);

-- ID 55: ASUS RTX 5070 Ti Prime OC (304mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (55, 40, 330);

-- ID 56: INNO3D RTX 5060 Ti Twin X2 OC (250mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (56, 40, 332);

-- ID 57: Sapphire RX 9060 XT Pulse OC (244mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (57, 40, 333);

-- ID 58: ASRock AI PRO R9700 Creator (271mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (58, 40, 334);

-- ID 59: Zotac RTX 5090 ArcticStorm AIO (252mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (59, 40, 341);

-- ID 60: ASUS RX 9070 XT Prime OC White (312mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (60, 40, 335);

-- ID 61: PowerColor RX 7600 Fighter (241mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (61, 40, 336);

-- ID 63: ASUS RX 9070 Prime EVO OC (304mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (63, 40, 330);

-- ID 64: Gigabyte RTX 5050 D6 (145mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (64, 40, 337);

-- ID 65: Zotac RTX 5060 Ti Twin Edge OC White (225mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (65, 40, 322);

-- ID 67: Zotac RTX 5080 AMP Extreme Infinity (332mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (67, 40, 338);

-- ID 68: Palit RTX 5070 Infinity 3 (292mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (68, 40, 339);

-- ID 70: Zotac RTX 5050 Twin Edge OC (221mm)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (70, 40, 340);

-- ENDORFY
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (212, 49, 910); -- Navis F240
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (213, 41, 402); -- Fortis 5
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (214, 41, 403); -- Fera 5
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (215, 49, 912); -- Navis F360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (216, 49, 910); -- Navis F240 (standard)

-- Thermalright
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (217, 49, 912); -- Vision 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (218, 41, 404); -- Phantom Spirit 120
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (219, 41, 403); -- Assassin X 120
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (220, 49, 912); -- Aqua Elite 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (221, 49, 910); -- Vision 240

-- be quiet!
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (222, 41, 402); -- Dark Rock 5
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (223, 41, 405); -- Pure Rock Pro 3
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (225, 49, 912); -- Light Loop 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (226, 49, 910); -- Light Loop 240
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (227, 41, 405); -- Pure Rock 3

-- Pozostałe AiO 360mm
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (228, 49, 912); -- ASUS RYUO IV 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (229, 49, 912); -- Krux HydroGlance 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (231, 49, 912); -- Genesis Hydria 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (232, 49, 912); -- Genesis Hydria 360 czarne
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (233, 49, 912); -- MasterLiquid 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (237, 49, 912); -- MSI MAG A13 360
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (240, 49, 912); -- Kraken Plus 360

-- Pozostałe AiO 240mm / 280mm
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (224, 49, 910); -- ASUS ROG STRIX LC III 240
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (230, 49, 910); -- Genesis Hydria 240
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (234, 49, 910); -- MasterLiquid 240
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (238, 49, 910); -- MSI MAG A13 240
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (239, 49, 910); -- MSI MAG CORELIQUID E240 WHITE
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (241, 49, 911); -- Kraken Elite 280

-- Powietrzne Premium
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (235, 41, 408); -- Savio Vortex X2 ARGB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (236, 41, 406); -- Noctua NH-D15

-- Obudowy obsługujące radiator 240mm
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(244, 50, 920), -- SMX Coffer
(258, 50, 920), -- KRUX Helio
(260, 50, 920), -- KRUX Vako
(261, 50, 920), -- ENDORFY Ventum 200
(264, 50, 920), -- DarkFlash DB330M Mesh White
(266, 50, 920); -- DarkFlash DB330M Mesh Black

-- Obudowy obsługujące radiator 360mm
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(242, 50, 922), -- ENDORFY Aquarius 8000 Corona
(243, 50, 922), -- SMX Cassette
(245, 50, 922), -- SMX Chest TG
(246, 50, 922), -- Genesis DIAXID 605F
(247, 50, 922), -- SMX Croft
(248, 50, 922), -- Lian Li DAN A3
(249, 50, 922), -- Fractal Design Meshify 3
(250, 50, 922), -- ENDORFY Arx 700 Air
(251, 50, 922), -- Lian Li O11D EVO RGB
(252, 50, 922), -- MSI MAG PANO 100R PZ
(253, 50, 922), -- Deepcool CC560 ARGB
(254, 50, 922), -- SMX Capsule
(255, 50, 922), -- NZXT H7 FLOW
(256, 50, 922), -- SMX Pyxis
(257, 50, 922), -- Lian Li Lancool 217
(259, 50, 922), -- be quiet! Pure Base 500DX
(262, 50, 922), -- ASUS TUF GAMING GT502
(263, 50, 922), -- DarkFlash DS900W
(265, 50, 922), -- DarkFlash DS900 Mesh
(267, 50, 922), -- ENDORFY Regnum 400
(269, 50, 922), -- DarkFlash DS900WS
(270, 50, 922), -- NZXT H9 FLOW
(271, 50, 922), -- be quiet! Light Base 500
(272, 50, 922); -- be quiet! PURE BASE 501

-- Intel B760/Z790 (Obsługuje 12, 13 i 14 gen)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (185, 43, 600); -- ASUS PRIME B760M-A
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (185, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (185, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (188, 43, 600); -- ASUS PRIME Z790-P
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (188, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (188, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (191, 43, 600); -- Gigabyte B760M DS3H DDR4
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (191, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (191, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (194, 43, 600); -- Gigabyte B760M DS3H WF6E GEN5
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (194, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (194, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (198, 43, 600); -- ASRock B760M-HDV/M.2 D4
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (198, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (198, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (199, 43, 600); -- ASRock Z790 Pro RS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (199, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (199, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (200, 43, 600); -- ASRock Z790 Steel Legend
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (200, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (200, 43, 602);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (210, 43, 600); -- MSI Z790 GAMING PLUS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (210, 43, 601);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (210, 43, 602);

-- Intel B860 (Obsługuje Intel Core Ultra Gen 2)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (182, 43, 603); -- ASUS TUF GAMING B860-PLUS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (195, 43, 603); -- Gigabyte B860M A ELT
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (203, 43, 603); -- ASRock B860M-H2
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (204, 43, 603); -- ASRock B860 Pro-A
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (205, 43, 603); -- ASRock B860 LiveMixer
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (206, 43, 603); -- MSI MAG B860 TOMAHAWK
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (207, 43, 603); -- MSI B860 GAMING PLUS

-- AMD B550 (Obsługuje Ryzen 3000, 4000 i 5000)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (186, 43, 604); -- ASUS PRIME B550M-A
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (186, 43, 605);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (186, 43, 606);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (190, 43, 604); -- Gigabyte B550 GAMING X V2
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (190, 43, 605);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (190, 43, 606);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (197, 43, 604); -- Gigabyte B550 EAGLE
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (197, 43, 605);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (197, 43, 606);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (201, 43, 604); -- ASRock B550M-HDV
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (201, 43, 605);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (201, 43, 606);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (202, 43, 604); -- ASRock B550M PRO4
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (202, 43, 605);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (202, 43, 606);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (211, 43, 604); -- MSI MPG B550 GAMING PLUS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (211, 43, 605);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (211, 43, 606);

-- AMD B650/B850 (Obsługuje Ryzen 7000, 8000 i 9000)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (183, 43, 607); -- ASUS TUF GAMING B850-PLUS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (183, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (183, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (184, 43, 607); -- ASUS B850M MAX
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (184, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (184, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (187, 43, 607); -- ASUS TUF GAMING B650E-E
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (187, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (187, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (189, 43, 607); -- Gigabyte B650 EAGLE AX
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (189, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (189, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (192, 43, 607); -- Gigabyte B650 GAMING X AX V2
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (192, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (192, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (193, 43, 607); -- Gigabyte B650M S2H
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (193, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (193, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (196, 43, 607); -- Gigabyte B850 EAGLE
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (196, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (196, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (208, 43, 607); -- MSI MAG B850M MORTAR
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (208, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (208, 43, 609);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (209, 43, 607); -- MSI PRO B850M-P
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (209, 43, 608);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (209, 43, 609);
-- ASUS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (182, 44, 513); -- B860-PLUS (Intel Ultra, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (183, 44, 513); -- B850-PLUS (AMD AM5, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (184, 44, 512); -- B850M MAX (AMD AM5, 2xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (185, 44, 511); -- B760M-A D4 (Intel, 4xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (186, 44, 511); -- B550M-A (AMD AM4, 4xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (187, 44, 513); -- B650E-E (AMD AM5, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (188, 44, 513); -- Z790-P (Intel, 4xDDR5)

-- Gigabyte
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (189, 44, 513); -- B650 EAGLE (AMD AM5, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (190, 44, 511); -- B550 GAMING X (AMD AM4, 4xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (191, 44, 511); -- B760M DS3H D4 (Intel, 4xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (192, 44, 513); -- B650 GAMING X AX (AMD AM5, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (193, 44, 512); -- B650M S2H (AMD AM5, 2xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (194, 44, 513); -- B760M DS3H GEN5 (Intel, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (195, 44, 513); -- B860M A ELT (Intel Ultra, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (196, 44, 513); -- B850 EAGLE (AMD AM5, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (197, 44, 511); -- B550 EAGLE (AMD AM4, 4xDDR4)

-- ASRock
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (198, 44, 510); -- B760M-HDV D4 (Intel, 2xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (199, 44, 513); -- Z790 Pro RS (Intel, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (200, 44, 513); -- Z790 Steel Legend (Intel, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (201, 44, 510); -- B550M-HDV (AMD AM4, 2xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (202, 44, 511); -- B550M PRO4 (AMD AM4, 4xDDR4)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (203, 44, 512); -- B860M-H2 (Intel Ultra, 2xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (204, 44, 513); -- B860 Pro-A (Intel Ultra, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (205, 44, 513); -- B860 LiveMixer (Intel Ultra, 4xDDR5)

-- MSI
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (206, 44, 513); -- MAG B860 TOMAHAWK (Intel Ultra, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (207, 44, 513); -- B860 GAMING PLUS (Intel Ultra, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (208, 44, 513); -- MAG B850M MORTAR (AMD AM5, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (209, 44, 512); -- PRO B850M-P (AMD AM5, 2xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (210, 44, 513); -- Z790 GAMING PLUS (Intel, 4xDDR5)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (211, 44, 511);

-- AMD Ryzen Seria 5000 (ID 606: AMD Ryzen 5000)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (1, 42, 616); -- Ryzen 5 5600
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (2, 42, 616); -- Ryzen 5 5500
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (3, 42, 616); -- Ryzen 5 5600XT
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (4, 42, 616); -- Ryzen 7 5700X
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (5, 42, 616); -- Ryzen 7 5800X

-- AMD Ryzen Seria 7000 (ID 607: AMD Ryzen 7000)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (29, 42, 617); -- Ryzen 5 7600X
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (30, 42, 617); -- Ryzen 5 7600
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (35, 42, 617); -- Ryzen 7 7800X3D
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (164, 42, 617); -- Ryzen 5 7500X3D

-- AMD Ryzen Seria 8000 (ID 608: AMD Ryzen 8000)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (173, 42, 618); -- Ryzen 5 8400F
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (174, 42, 618); -- Ryzen 5 8500G

-- AMD Ryzen Seria 9000 (ID 609: AMD Ryzen 9000)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (38, 42, 619); -- Ryzen 7 9800X3D
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (165, 42, 619); -- Ryzen 7 9700X
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (166, 42, 619); -- Ryzen 9 9950X3D
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (167, 42, 619); -- Ryzen 5 9600X
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (168, 42, 619); -- Ryzen 7 9850X3D

-- Intel 12th Gen (ID 600)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (171, 42, 610); -- i5-12400F
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (179, 42, 610); -- i5-12600KF
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (180, 42, 610); -- i7-12700KF

-- Intel 14th Gen (ID 602)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (41, 42, 612); -- i7-14700KF
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (169, 42, 612); -- i9-14900K
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (170, 42, 612); -- i9-14900KF
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (175, 42, 612); -- i5-14400F
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (178, 42, 612); -- i5-14600KF

-- Intel Core Ultra Gen 2 (ID 603: LGA 1851)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (26, 42, 613); -- Ultra 5 245KF
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (27, 42, 613); -- Ultra 5 225F
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (172, 42, 613); -- Ultra 7 265KF
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (176, 42, 613); -- Ultra 5 225
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (177, 42, 613); -- Ultra 5 250KF Plus
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (181, 42, 613); -- Ultra 9 285
-- Zestawy 2 modułów (ID 701)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (23, 45, 701); -- Patriot 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (28, 45, 701); -- GOODRAM 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (31, 45, 701); -- Kingston 2x8GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (32, 45, 701); -- GOODRAM 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (33, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (34, 45, 701); -- Patriot 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (36, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (39, 45, 701); -- G.SKILL 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (40, 45, 701); -- Lexar 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (42, 45, 701); -- GOODRAM 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (43, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (71, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (72, 45, 701); -- ADATA 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (74, 45, 701); -- Kingston 2x8GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (75, 45, 701); -- GOODRAM 2x32GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (76, 45, 701); -- GOODRAM 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (77, 45, 701); -- Patriot 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (78, 45, 701); -- Crucial 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (80, 45, 701); -- Patriot 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (82, 45, 701); -- Kingston 2x32GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (84, 45, 701); -- Kingston 2x8GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (85, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (86, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (87, 45, 701); -- Corsair 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (89, 45, 701); -- Kingston 2x8GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (90, 45, 701); -- GOODRAM 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (91, 45, 701); -- Kingston 2x16GB
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (93, 45, 701); -- Patriot 2x32GB

-- Pojedyncze moduły (ID 700)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (83, 45, 700); -- Kingston Impact (16GB)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (88, 45, 700); -- Crucial (1x16GB)

-- Karty z 1x 8-pin PCIe (ID 801)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(14, 46, 801), (15, 46, 801), (37, 46, 801), (44, 46, 801), (52, 46, 801),
(56, 46, 801), (57, 46, 801), (61, 46, 801), (62, 46, 801), (64, 46, 801),
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(14, 46, 801), (15, 46, 801), (37, 46, 801), (44, 46, 801), (52, 46, 801),
(56, 46, 801), (57, 46, 801), (61, 46, 801), (62, 46, 801), (64, 46, 801),
(65, 46, 801), (68, 46, 801), (69, 46, 801), (70, 46, 801);

-- Karty bez dodatkowego zasilania (ID 803)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(53, 46, 803); -- Intel Arc Pro B50

-- Karty z 1x 12VHPWR (ID 802) - Nowe serie RTX 5000 i mocne jednostki
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(45, 46, 802), (47, 46, 802), (48, 46, 802), (49, 46, 802), (50, 46, 802),
(51, 46, 802), (55, 46, 802), (58, 46, 802), (59, 46, 802), (66, 46, 802), (67, 46, 802);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(45, 46, 802), (46, 46, 802), (47, 46, 802), (48, 46, 802), (49, 46, 802),
(50, 46, 802), (51, 46, 802), (55, 46, 802), (59, 46, 802), (66, 46, 802), (67, 46, 802);

-- Karty wymagające 2x 8-pin PCIe (Podwójne wpisy dla produktu)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(54, 46, 801), (54, 46, 801), -- Sapphire Pure
(60, 46, 801), (60, 46, 801), -- ASUS RX 9070
(63, 46, 801), (63, 46, 801); -- ASUS RX 9070 Prime

-- Karty wymagające 3x 8-pin PCIe
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(46, 46, 801), (46, 46, 801), (46, 46, 801), -- Gigabyte RX 9070 XT
(60, 46, 801); -- ASUS RX 9070 XT Prime OC White (trzeci 8-pin)

-- Standardowe płyty (1x 8-pin CPU - ID 811)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(184, 47, 811), (185, 47, 811), (186, 47, 811), (191, 47, 811), (193, 47, 811),
(190, 47, 811), (194, 47, 811), (197, 47, 811), (198, 47, 811), (201, 47, 811),
(202, 47, 811), (203, 47, 811);
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(184, 47, 811), (185, 47, 811), (186, 47, 811), (191, 47, 811), (193, 47, 811),
(194, 47, 811), (197, 47, 811), (198, 47, 811), (201, 47, 811), (202, 47, 811), (203, 47, 811);

-- Płyty dla entuzjastów (2x 8-pin CPU - Podwójne wpisy)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(182, 47, 811), (182, 47, 811), (183, 47, 811), (183, 47, 811),
(187, 47, 811), (187, 47, 811), (188, 47, 811), (188, 47, 811),
(189, 47, 811), (189, 47, 811), (192, 47, 811), (192, 47, 811),
(195, 47, 811), (195, 47, 811), (196, 47, 811), (196, 47, 811),
(199, 47, 811), (199, 47, 811), (200, 47, 811), (200, 47, 811),
(204, 47, 811), (204, 47, 811), (205, 47, 811), (205, 47, 811),
(206, 47, 811), (206, 47, 811), (207, 47, 811), (207, 47, 811),
(208, 47, 811), (208, 47, 811), (209, 47, 811), (209, 47, 811),
(210, 47, 811), (210, 47, 811), (211, 47, 811), (211, 47, 811);

-- Zasilacze High-End (ATX 3.1 / 12VHPWR + 2x CPU)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
-- be quiet! Pure Power 13 M / Dark Power 14
(112, 46, 802), (112, 47, 811), (112, 47, 811),
(120, 46, 802), (120, 47, 811), (120, 47, 811),
(125, 46, 802), (125, 47, 811), (125, 47, 811),
(131, 46, 802), (131, 47, 811), (131, 47, 811),
(136, 46, 802), (136, 47, 811), (136, 47, 811),
-- MSI MPG/MEG
(122, 46, 802), (122, 47, 811), (122, 47, 811),
(148, 46, 802), (148, 47, 811), (148, 47, 811),
-- ENDORFY Supremo FM6 (ATX 3.1)
(115, 46, 802), (115, 47, 811), (115, 47, 811),
(119, 46, 802), (119, 47, 811), (119, 47, 811),
(127, 46, 802), (127, 47, 811), (127, 47, 811);

-- Pozostałe zasilacze ATX 3.1 / 12VHPWR
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(113, 46, 802), (113, 47, 811), (113, 47, 811), -- be quiet! Power Zone 2 1000W
(116, 46, 802), (116, 47, 811), (116, 47, 811), -- Gigabyte UD750GM PG5 V2
(132, 46, 802), (132, 47, 811), (132, 47, 811), -- Corsair HXi Shift 1000W
(134, 46, 802), (134, 47, 811), -- Corsair RM650e ATX 3.1
(139, 46, 802), (139, 47, 811), (139, 47, 811), -- Fractal Ion 3 Gold 1000W
(141, 46, 802), (141, 47, 811), (141, 47, 811), -- Fractal Ion 3 Gold 850W
(144, 46, 802), (144, 47, 811), (144, 47, 811), -- Corsair RM850e ATX 3.1
(147, 46, 802), (147, 47, 811), (147, 47, 811), -- Corsair RM750e ATX 3.1
(149, 46, 802), (149, 47, 811), (149, 47, 811), -- Gigabyte Aorus Elite P 850W
(163, 46, 802), (163, 47, 811); -- Cooler Master MWE Bronze V3 650W

-- Zasilacze Standardowe (Bez 12VHPWR, zazwyczaj 2x 8-pin PCIe i 1x lub 2x CPU)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
-- Vero L5 / System Power 11
(129, 46, 801), (129, 46, 801), (129, 47, 811),
(117, 46, 801), (117, 46, 801), (117, 47, 811), (117, 47, 811),
(130, 46, 801), (130, 46, 801), (130, 47, 811),
-- MAG 650W / 550W
(121, 46, 801), (121, 46, 801), (121, 47, 811),
(124, 46, 801), (124, 47, 811),
-- ASRock Challenger
(150, 46, 801), (150, 47, 811),
(151, 46, 801), (151, 46, 801), (151, 47, 811),
(152, 46, 801), (152, 46, 801), (152, 47, 811),
(153, 46, 801), (153, 46, 801), (153, 47, 811), (153, 47, 811);

-- Zasilacze obsługujące karty bez dodatkowego zasilania PCIe
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES
(112, 46, 803), (113, 46, 803), (115, 46, 803), (116, 46, 803), (117, 46, 803),
(119, 46, 803), (120, 46, 803), (121, 46, 803), (122, 46, 803), (124, 46, 803),
(125, 46, 803), (127, 46, 803), (129, 46, 803), (130, 46, 803), (131, 46, 803),
(132, 46, 803), (134, 46, 803), (136, 46, 803), (139, 46, 803), (141, 46, 803),
(144, 46, 803), (147, 46, 803), (148, 46, 803), (149, 46, 803), (150, 46, 803),
(151, 46, 803), (152, 46, 803), (153, 46, 803), (163, 46, 803);

-- ASUS
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (188, 48, 902); -- PRIME Z790-P (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (182, 48, 902); -- TUF B860-PLUS (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (184, 48, 901); -- B850M MAX (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (185, 48, 901); -- PRIME B760M-A (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (183, 48, 902); -- TUF B850-PLUS (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (186, 48, 901); -- PRIME B550M-A (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (187, 48, 903); -- TUF B650E-E (4 sloty)

-- Gigabyte
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (189, 48, 902); -- B650 EAGLE AX (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (190, 48, 901); -- B550 GAMING X V2 (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (191, 48, 901); -- B760M DS3H (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (192, 48, 902); -- B650 GAMING X AX (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (193, 48, 900); -- B650M S2H (1 slot)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (194, 48, 901); -- B760M DS3H GEN5 (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (195, 48, 902); -- B860M A ELT (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (196, 48, 902); -- B850 EAGLE (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (197, 48, 901); -- B550 EAGLE (2 sloty)

-- ASRock
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (198, 48, 901); -- B760M-HDV (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (199, 48, 903); -- Z790 Pro RS (4 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (200, 48, 903); -- Z790 Steel Legend (4 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (201, 48, 900); -- B550M-HDV (1 slot)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (202, 48, 901); -- B550M PRO4 (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (203, 48, 901); -- B860M-H2 (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (204, 48, 902); -- B860 Pro-A (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (205, 48, 902); -- B860 LiveMixer (3 sloty)

-- MSI
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (206, 48, 903); -- B860 TOMAHAWK (4 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (207, 48, 902); -- B860 GAMING PLUS (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (208, 48, 902); -- B850M MORTAR (3 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (209, 48, 901); -- PRO B850M-P (2 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (210, 48, 903); -- Z790 GAMING PLUS (4 sloty)
INSERT INTO public.product_attributes (product_id, attribute_category_id, attribute_value_id) VALUES (211, 48, 901); -- MPG B550 GAMING PLUS (2 sloty)

