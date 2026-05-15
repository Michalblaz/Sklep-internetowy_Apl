--
-- PostgreSQL database dump
--

\restrict x3jJu6jIpBO3sbBEqnWdpfzmo8oTEptTfNU86AQCi8zlwtb8KBHKa7yk98I5Icu

-- Dumped from database version 18.3
-- Dumped by pg_dump version 18.3

-- Started on 2026-05-05 09:42:39 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 3510 (class 0 OID 16508)
-- Dependencies: 251
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.users (id, email, password_hash, first_name, last_name, phone, "is_Admin") FROM stdin;
1	mb131406@stud.ur.edu.pl	$2y$12$jp7RO2jXONMyriETrE7xxeNl9ziH4gDRxzyzAy2yga0ubsESR4eeS	Michał	Błaż	123456789	f
\.


--
-- TOC entry 3517 (class 0 OID 0)
-- Dependencies: 252
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.users_id_seq', 1, true);


-- Completed on 2026-05-05 09:42:39 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict x3jJu6jIpBO3sbBEqnWdpfzmo8oTEptTfNU86AQCi8zlwtb8KBHKa7yk98I5Icu

