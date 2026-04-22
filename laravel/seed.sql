--
-- PostgreSQL database dump
--

\restrict kcwoJpA7FjfWzxdyG3NacALcbT2ByN4gK5zqppvgJEZLVWmVR6xZhngDWSivnqT

-- Dumped from database version 18.0
-- Dumped by pg_dump version 18.0

-- Started on 2026-04-22 13:11:15

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
-- TOC entry 9 (class 2615 OID 33616)
-- Name: auth; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA auth;


ALTER SCHEMA auth OWNER TO postgres;

--
-- TOC entry 10 (class 2615 OID 33617)
-- Name: extensions; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA extensions;


ALTER SCHEMA extensions OWNER TO postgres;

--
-- TOC entry 11 (class 2615 OID 33618)
-- Name: graphql; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA graphql;


ALTER SCHEMA graphql OWNER TO postgres;

--
-- TOC entry 12 (class 2615 OID 33619)
-- Name: graphql_public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA graphql_public;


ALTER SCHEMA graphql_public OWNER TO postgres;

--
-- TOC entry 13 (class 2615 OID 33620)
-- Name: pgbouncer; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA pgbouncer;


ALTER SCHEMA pgbouncer OWNER TO postgres;

--
-- TOC entry 14 (class 2615 OID 33621)
-- Name: realtime; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA realtime;


ALTER SCHEMA realtime OWNER TO postgres;

--
-- TOC entry 15 (class 2615 OID 33622)
-- Name: storage; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA storage;


ALTER SCHEMA storage OWNER TO postgres;

--
-- TOC entry 16 (class 2615 OID 33623)
-- Name: vault; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA vault;


ALTER SCHEMA vault OWNER TO postgres;

--
-- TOC entry 2 (class 3079 OID 33624)
-- Name: pg_stat_statements; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pg_stat_statements WITH SCHEMA extensions;


--
-- TOC entry 5899 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION pg_stat_statements; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pg_stat_statements IS 'track planning and execution statistics of all SQL statements executed';


--
-- TOC entry 3 (class 3079 OID 33668)
-- Name: pgcrypto; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS pgcrypto WITH SCHEMA extensions;


--
-- TOC entry 5900 (class 0 OID 0)
-- Dependencies: 3
-- Name: EXTENSION pgcrypto; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION pgcrypto IS 'cryptographic functions';


--
-- TOC entry 4 (class 3079 OID 33706)
-- Name: uuid-ossp; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA extensions;


--
-- TOC entry 5901 (class 0 OID 0)
-- Dependencies: 4
-- Name: EXTENSION "uuid-ossp"; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';


--
-- TOC entry 1034 (class 1247 OID 33718)
-- Name: aal_level; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.aal_level AS ENUM (
    'aal1',
    'aal2',
    'aal3'
);


ALTER TYPE auth.aal_level OWNER TO postgres;

--
-- TOC entry 1037 (class 1247 OID 33726)
-- Name: code_challenge_method; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.code_challenge_method AS ENUM (
    's256',
    'plain'
);


ALTER TYPE auth.code_challenge_method OWNER TO postgres;

--
-- TOC entry 1040 (class 1247 OID 33732)
-- Name: factor_status; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.factor_status AS ENUM (
    'unverified',
    'verified'
);


ALTER TYPE auth.factor_status OWNER TO postgres;

--
-- TOC entry 1043 (class 1247 OID 33738)
-- Name: factor_type; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.factor_type AS ENUM (
    'totp',
    'webauthn',
    'phone'
);


ALTER TYPE auth.factor_type OWNER TO postgres;

--
-- TOC entry 1046 (class 1247 OID 33746)
-- Name: oauth_authorization_status; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.oauth_authorization_status AS ENUM (
    'pending',
    'approved',
    'denied',
    'expired'
);


ALTER TYPE auth.oauth_authorization_status OWNER TO postgres;

--
-- TOC entry 1049 (class 1247 OID 33756)
-- Name: oauth_client_type; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.oauth_client_type AS ENUM (
    'public',
    'confidential'
);


ALTER TYPE auth.oauth_client_type OWNER TO postgres;

--
-- TOC entry 1052 (class 1247 OID 33762)
-- Name: oauth_registration_type; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.oauth_registration_type AS ENUM (
    'dynamic',
    'manual'
);


ALTER TYPE auth.oauth_registration_type OWNER TO postgres;

--
-- TOC entry 1055 (class 1247 OID 33768)
-- Name: oauth_response_type; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.oauth_response_type AS ENUM (
    'code'
);


ALTER TYPE auth.oauth_response_type OWNER TO postgres;

--
-- TOC entry 1058 (class 1247 OID 33772)
-- Name: one_time_token_type; Type: TYPE; Schema: auth; Owner: postgres
--

CREATE TYPE auth.one_time_token_type AS ENUM (
    'confirmation_token',
    'reauthentication_token',
    'recovery_token',
    'email_change_token_new',
    'email_change_token_current',
    'phone_change_token'
);


ALTER TYPE auth.one_time_token_type OWNER TO postgres;

--
-- TOC entry 1061 (class 1247 OID 33786)
-- Name: action; Type: TYPE; Schema: realtime; Owner: postgres
--

CREATE TYPE realtime.action AS ENUM (
    'INSERT',
    'UPDATE',
    'DELETE',
    'TRUNCATE',
    'ERROR'
);


ALTER TYPE realtime.action OWNER TO postgres;

--
-- TOC entry 1064 (class 1247 OID 33798)
-- Name: equality_op; Type: TYPE; Schema: realtime; Owner: postgres
--

CREATE TYPE realtime.equality_op AS ENUM (
    'eq',
    'neq',
    'lt',
    'lte',
    'gt',
    'gte',
    'in'
);


ALTER TYPE realtime.equality_op OWNER TO postgres;

--
-- TOC entry 1067 (class 1247 OID 33815)
-- Name: user_defined_filter; Type: TYPE; Schema: realtime; Owner: postgres
--

CREATE TYPE realtime.user_defined_filter AS (
	column_name text,
	op realtime.equality_op,
	value text
);


ALTER TYPE realtime.user_defined_filter OWNER TO postgres;

--
-- TOC entry 1070 (class 1247 OID 33818)
-- Name: wal_column; Type: TYPE; Schema: realtime; Owner: postgres
--

CREATE TYPE realtime.wal_column AS (
	name text,
	type_name text,
	type_oid oid,
	value jsonb,
	is_pkey boolean,
	is_selectable boolean
);


ALTER TYPE realtime.wal_column OWNER TO postgres;

--
-- TOC entry 1073 (class 1247 OID 33821)
-- Name: wal_rls; Type: TYPE; Schema: realtime; Owner: postgres
--

CREATE TYPE realtime.wal_rls AS (
	wal jsonb,
	is_rls_enabled boolean,
	subscription_ids uuid[],
	errors text[]
);


ALTER TYPE realtime.wal_rls OWNER TO postgres;

--
-- TOC entry 1076 (class 1247 OID 33823)
-- Name: buckettype; Type: TYPE; Schema: storage; Owner: postgres
--

CREATE TYPE storage.buckettype AS ENUM (
    'STANDARD',
    'ANALYTICS',
    'VECTOR'
);


ALTER TYPE storage.buckettype OWNER TO postgres;

--
-- TOC entry 317 (class 1255 OID 33829)
-- Name: email(); Type: FUNCTION; Schema: auth; Owner: postgres
--

CREATE FUNCTION auth.email() RETURNS text
    LANGUAGE sql STABLE
    AS $$
  select 
  coalesce(
    nullif(current_setting('request.jwt.claim.email', true), ''),
    (nullif(current_setting('request.jwt.claims', true), '')::jsonb ->> 'email')
  )::text
$$;


ALTER FUNCTION auth.email() OWNER TO postgres;

--
-- TOC entry 5902 (class 0 OID 0)
-- Dependencies: 317
-- Name: FUNCTION email(); Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON FUNCTION auth.email() IS 'Deprecated. Use auth.jwt() -> ''email'' instead.';


--
-- TOC entry 403 (class 1255 OID 33830)
-- Name: jwt(); Type: FUNCTION; Schema: auth; Owner: postgres
--

CREATE FUNCTION auth.jwt() RETURNS jsonb
    LANGUAGE sql STABLE
    AS $$
  select 
    coalesce(
        nullif(current_setting('request.jwt.claim', true), ''),
        nullif(current_setting('request.jwt.claims', true), '')
    )::jsonb
$$;


ALTER FUNCTION auth.jwt() OWNER TO postgres;

--
-- TOC entry 312 (class 1255 OID 33831)
-- Name: role(); Type: FUNCTION; Schema: auth; Owner: postgres
--

CREATE FUNCTION auth.role() RETURNS text
    LANGUAGE sql STABLE
    AS $$
  select 
  coalesce(
    nullif(current_setting('request.jwt.claim.role', true), ''),
    (nullif(current_setting('request.jwt.claims', true), '')::jsonb ->> 'role')
  )::text
$$;


ALTER FUNCTION auth.role() OWNER TO postgres;

--
-- TOC entry 5903 (class 0 OID 0)
-- Dependencies: 312
-- Name: FUNCTION role(); Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON FUNCTION auth.role() IS 'Deprecated. Use auth.jwt() -> ''role'' instead.';


--
-- TOC entry 351 (class 1255 OID 33832)
-- Name: uid(); Type: FUNCTION; Schema: auth; Owner: postgres
--

CREATE FUNCTION auth.uid() RETURNS uuid
    LANGUAGE sql STABLE
    AS $$
  select 
  coalesce(
    nullif(current_setting('request.jwt.claim.sub', true), ''),
    (nullif(current_setting('request.jwt.claims', true), '')::jsonb ->> 'sub')
  )::uuid
$$;


ALTER FUNCTION auth.uid() OWNER TO postgres;

--
-- TOC entry 5904 (class 0 OID 0)
-- Dependencies: 351
-- Name: FUNCTION uid(); Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON FUNCTION auth.uid() IS 'Deprecated. Use auth.jwt() -> ''sub'' instead.';


--
-- TOC entry 355 (class 1255 OID 33833)
-- Name: grant_pg_cron_access(); Type: FUNCTION; Schema: extensions; Owner: postgres
--

CREATE FUNCTION extensions.grant_pg_cron_access() RETURNS event_trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF EXISTS (
    SELECT
    FROM pg_event_trigger_ddl_commands() AS ev
    JOIN pg_extension AS ext
    ON ev.objid = ext.oid
    WHERE ext.extname = 'pg_cron'
  )
  THEN
    grant usage on schema cron to postgres with grant option;

    alter default privileges in schema cron grant all on tables to postgres with grant option;
    alter default privileges in schema cron grant all on functions to postgres with grant option;
    alter default privileges in schema cron grant all on sequences to postgres with grant option;

    alter default privileges for user supabase_admin in schema cron grant all
        on sequences to postgres with grant option;
    alter default privileges for user supabase_admin in schema cron grant all
        on tables to postgres with grant option;
    alter default privileges for user supabase_admin in schema cron grant all
        on functions to postgres with grant option;

    grant all privileges on all tables in schema cron to postgres with grant option;
    revoke all on table cron.job from postgres;
    grant select on table cron.job to postgres with grant option;
  END IF;
END;
$$;


ALTER FUNCTION extensions.grant_pg_cron_access() OWNER TO postgres;

--
-- TOC entry 5905 (class 0 OID 0)
-- Dependencies: 355
-- Name: FUNCTION grant_pg_cron_access(); Type: COMMENT; Schema: extensions; Owner: postgres
--

COMMENT ON FUNCTION extensions.grant_pg_cron_access() IS 'Grants access to pg_cron';


--
-- TOC entry 325 (class 1255 OID 33834)
-- Name: grant_pg_graphql_access(); Type: FUNCTION; Schema: extensions; Owner: postgres
--

CREATE FUNCTION extensions.grant_pg_graphql_access() RETURNS event_trigger
    LANGUAGE plpgsql
    AS $_$
DECLARE
    func_is_graphql_resolve bool;
BEGIN
    func_is_graphql_resolve = (
        SELECT n.proname = 'resolve'
        FROM pg_event_trigger_ddl_commands() AS ev
        LEFT JOIN pg_catalog.pg_proc AS n
        ON ev.objid = n.oid
    );

    IF func_is_graphql_resolve
    THEN
        -- Update public wrapper to pass all arguments through to the pg_graphql resolve func
        DROP FUNCTION IF EXISTS graphql_public.graphql;
        create or replace function graphql_public.graphql(
            "operationName" text default null,
            query text default null,
            variables jsonb default null,
            extensions jsonb default null
        )
            returns jsonb
            language sql
        as $$
            select graphql.resolve(
                query := query,
                variables := coalesce(variables, '{}'),
                "operationName" := "operationName",
                extensions := extensions
            );
        $$;

        -- This hook executes when `graphql.resolve` is created. That is not necessarily the last
        -- function in the extension so we need to grant permissions on existing entities AND
        -- update default permissions to any others that are created after `graphql.resolve`
        grant usage on schema graphql to postgres, anon, authenticated, service_role;
        grant select on all tables in schema graphql to postgres, anon, authenticated, service_role;
        grant execute on all functions in schema graphql to postgres, anon, authenticated, service_role;
        grant all on all sequences in schema graphql to postgres, anon, authenticated, service_role;
        alter default privileges in schema graphql grant all on tables to postgres, anon, authenticated, service_role;
        alter default privileges in schema graphql grant all on functions to postgres, anon, authenticated, service_role;
        alter default privileges in schema graphql grant all on sequences to postgres, anon, authenticated, service_role;

        -- Allow postgres role to allow granting usage on graphql and graphql_public schemas to custom roles
        grant usage on schema graphql_public to postgres with grant option;
        grant usage on schema graphql to postgres with grant option;
    END IF;

END;
$_$;


ALTER FUNCTION extensions.grant_pg_graphql_access() OWNER TO postgres;

--
-- TOC entry 5906 (class 0 OID 0)
-- Dependencies: 325
-- Name: FUNCTION grant_pg_graphql_access(); Type: COMMENT; Schema: extensions; Owner: postgres
--

COMMENT ON FUNCTION extensions.grant_pg_graphql_access() IS 'Grants access to pg_graphql';


--
-- TOC entry 341 (class 1255 OID 33835)
-- Name: grant_pg_net_access(); Type: FUNCTION; Schema: extensions; Owner: postgres
--

CREATE FUNCTION extensions.grant_pg_net_access() RETURNS event_trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
  IF EXISTS (
    SELECT 1
    FROM pg_event_trigger_ddl_commands() AS ev
    JOIN pg_extension AS ext
    ON ev.objid = ext.oid
    WHERE ext.extname = 'pg_net'
  )
  THEN
    IF NOT EXISTS (
      SELECT 1
      FROM pg_roles
      WHERE rolname = 'supabase_functions_admin'
    )
    THEN
      CREATE USER supabase_functions_admin NOINHERIT CREATEROLE LOGIN NOREPLICATION;
    END IF;

    GRANT USAGE ON SCHEMA net TO supabase_functions_admin, postgres, anon, authenticated, service_role;

    IF EXISTS (
      SELECT FROM pg_extension
      WHERE extname = 'pg_net'
      -- all versions in use on existing projects as of 2025-02-20
      -- version 0.12.0 onwards don't need these applied
      AND extversion IN ('0.2', '0.6', '0.7', '0.7.1', '0.8', '0.10.0', '0.11.0')
    ) THEN
      ALTER function net.http_get(url text, params jsonb, headers jsonb, timeout_milliseconds integer) SECURITY DEFINER;
      ALTER function net.http_post(url text, body jsonb, params jsonb, headers jsonb, timeout_milliseconds integer) SECURITY DEFINER;

      ALTER function net.http_get(url text, params jsonb, headers jsonb, timeout_milliseconds integer) SET search_path = net;
      ALTER function net.http_post(url text, body jsonb, params jsonb, headers jsonb, timeout_milliseconds integer) SET search_path = net;

      REVOKE ALL ON FUNCTION net.http_get(url text, params jsonb, headers jsonb, timeout_milliseconds integer) FROM PUBLIC;
      REVOKE ALL ON FUNCTION net.http_post(url text, body jsonb, params jsonb, headers jsonb, timeout_milliseconds integer) FROM PUBLIC;

      GRANT EXECUTE ON FUNCTION net.http_get(url text, params jsonb, headers jsonb, timeout_milliseconds integer) TO supabase_functions_admin, postgres, anon, authenticated, service_role;
      GRANT EXECUTE ON FUNCTION net.http_post(url text, body jsonb, params jsonb, headers jsonb, timeout_milliseconds integer) TO supabase_functions_admin, postgres, anon, authenticated, service_role;
    END IF;
  END IF;
END;
$$;


ALTER FUNCTION extensions.grant_pg_net_access() OWNER TO postgres;

--
-- TOC entry 5908 (class 0 OID 0)
-- Dependencies: 341
-- Name: FUNCTION grant_pg_net_access(); Type: COMMENT; Schema: extensions; Owner: postgres
--

COMMENT ON FUNCTION extensions.grant_pg_net_access() IS 'Grants access to pg_net';


--
-- TOC entry 385 (class 1255 OID 33836)
-- Name: pgrst_ddl_watch(); Type: FUNCTION; Schema: extensions; Owner: postgres
--

CREATE FUNCTION extensions.pgrst_ddl_watch() RETURNS event_trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
  cmd record;
BEGIN
  FOR cmd IN SELECT * FROM pg_event_trigger_ddl_commands()
  LOOP
    IF cmd.command_tag IN (
      'CREATE SCHEMA', 'ALTER SCHEMA'
    , 'CREATE TABLE', 'CREATE TABLE AS', 'SELECT INTO', 'ALTER TABLE'
    , 'CREATE FOREIGN TABLE', 'ALTER FOREIGN TABLE'
    , 'CREATE VIEW', 'ALTER VIEW'
    , 'CREATE MATERIALIZED VIEW', 'ALTER MATERIALIZED VIEW'
    , 'CREATE FUNCTION', 'ALTER FUNCTION'
    , 'CREATE TRIGGER'
    , 'CREATE TYPE', 'ALTER TYPE'
    , 'CREATE RULE'
    , 'COMMENT'
    )
    -- don't notify in case of CREATE TEMP table or other objects created on pg_temp
    AND cmd.schema_name is distinct from 'pg_temp'
    THEN
      NOTIFY pgrst, 'reload schema';
    END IF;
  END LOOP;
END; $$;


ALTER FUNCTION extensions.pgrst_ddl_watch() OWNER TO postgres;

--
-- TOC entry 373 (class 1255 OID 33837)
-- Name: pgrst_drop_watch(); Type: FUNCTION; Schema: extensions; Owner: postgres
--

CREATE FUNCTION extensions.pgrst_drop_watch() RETURNS event_trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
  obj record;
BEGIN
  FOR obj IN SELECT * FROM pg_event_trigger_dropped_objects()
  LOOP
    IF obj.object_type IN (
      'schema'
    , 'table'
    , 'foreign table'
    , 'view'
    , 'materialized view'
    , 'function'
    , 'trigger'
    , 'type'
    , 'rule'
    )
    AND obj.is_temporary IS false -- no pg_temp objects
    THEN
      NOTIFY pgrst, 'reload schema';
    END IF;
  END LOOP;
END; $$;


ALTER FUNCTION extensions.pgrst_drop_watch() OWNER TO postgres;

--
-- TOC entry 326 (class 1255 OID 33838)
-- Name: set_graphql_placeholder(); Type: FUNCTION; Schema: extensions; Owner: postgres
--

CREATE FUNCTION extensions.set_graphql_placeholder() RETURNS event_trigger
    LANGUAGE plpgsql
    AS $_$
    DECLARE
    graphql_is_dropped bool;
    BEGIN
    graphql_is_dropped = (
        SELECT ev.schema_name = 'graphql_public'
        FROM pg_event_trigger_dropped_objects() AS ev
        WHERE ev.schema_name = 'graphql_public'
    );

    IF graphql_is_dropped
    THEN
        create or replace function graphql_public.graphql(
            "operationName" text default null,
            query text default null,
            variables jsonb default null,
            extensions jsonb default null
        )
            returns jsonb
            language plpgsql
        as $$
            DECLARE
                server_version float;
            BEGIN
                server_version = (SELECT (SPLIT_PART((select version()), ' ', 2))::float);

                IF server_version >= 14 THEN
                    RETURN jsonb_build_object(
                        'errors', jsonb_build_array(
                            jsonb_build_object(
                                'message', 'pg_graphql extension is not enabled.'
                            )
                        )
                    );
                ELSE
                    RETURN jsonb_build_object(
                        'errors', jsonb_build_array(
                            jsonb_build_object(
                                'message', 'pg_graphql is only available on projects running Postgres 14 onwards.'
                            )
                        )
                    );
                END IF;
            END;
        $$;
    END IF;

    END;
$_$;


ALTER FUNCTION extensions.set_graphql_placeholder() OWNER TO postgres;

--
-- TOC entry 5911 (class 0 OID 0)
-- Dependencies: 326
-- Name: FUNCTION set_graphql_placeholder(); Type: COMMENT; Schema: extensions; Owner: postgres
--

COMMENT ON FUNCTION extensions.set_graphql_placeholder() IS 'Reintroduces placeholder function for graphql_public.graphql';


--
-- TOC entry 368 (class 1255 OID 33839)
-- Name: get_auth(text); Type: FUNCTION; Schema: pgbouncer; Owner: postgres
--

CREATE FUNCTION pgbouncer.get_auth(p_usename text) RETURNS TABLE(username text, password text)
    LANGUAGE plpgsql SECURITY DEFINER
    SET search_path TO ''
    AS $_$
  BEGIN
      RAISE DEBUG 'PgBouncer auth request: %', p_usename;

      RETURN QUERY
      SELECT
          rolname::text,
          CASE WHEN rolvaliduntil < now()
              THEN null
              ELSE rolpassword::text
          END
      FROM pg_authid
      WHERE rolname=$1 and rolcanlogin;
  END;
  $_$;


ALTER FUNCTION pgbouncer.get_auth(p_usename text) OWNER TO postgres;

--
-- TOC entry 390 (class 1255 OID 33840)
-- Name: add_product_with_attributes(text, integer, numeric, integer, json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.add_product_with_attributes(p_name text, p_category_id integer, p_price numeric, p_power integer, p_attributes json) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_product_id INT;
    attr RECORD;
    attr_id INT;
    attr_value_id INT;
BEGIN
    -- dodaj produkt
    INSERT INTO products (name, category_id, base_price, power_draw_w)
    VALUES (p_name, p_category_id, p_price, p_power)
    RETURNING id INTO new_product_id;

    -- iteracja po JSON (tylko jako input!)
    FOR attr IN SELECT * FROM json_each_text(p_attributes)
    LOOP
        -- znajdź attribute_id
        SELECT id INTO attr_id FROM attributes WHERE name = attr.key;

        -- znajdź value_id (jeśli istnieje)
        SELECT id INTO attr_value_id 
        FROM attribute_values 
        WHERE attribute_id = attr_id AND value = attr.value;

        -- insert
        INSERT INTO product_attributes (product_id, attribute_id, attribute_value_id, value_text)
        VALUES (new_product_id, attr_id, attr_value_id, attr.value);
    END LOOP;

    RETURN new_product_id;
END;
$$;


ALTER FUNCTION public.add_product_with_attributes(p_name text, p_category_id integer, p_price numeric, p_power integer, p_attributes json) OWNER TO postgres;

--
-- TOC entry 387 (class 1255 OID 33841)
-- Name: apply_rls(jsonb, integer); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.apply_rls(wal jsonb, max_record_bytes integer DEFAULT (1024 * 1024)) RETURNS SETOF realtime.wal_rls
    LANGUAGE plpgsql
    AS $$
declare
-- Regclass of the table e.g. public.notes
entity_ regclass = (quote_ident(wal ->> 'schema') || '.' || quote_ident(wal ->> 'table'))::regclass;

-- I, U, D, T: insert, update ...
action realtime.action = (
    case wal ->> 'action'
        when 'I' then 'INSERT'
        when 'U' then 'UPDATE'
        when 'D' then 'DELETE'
        else 'ERROR'
    end
);

-- Is row level security enabled for the table
is_rls_enabled bool = relrowsecurity from pg_class where oid = entity_;

subscriptions realtime.subscription[] = array_agg(subs)
    from
        realtime.subscription subs
    where
        subs.entity = entity_
        -- Filter by action early - only get subscriptions interested in this action
        -- action_filter column can be: '*' (all), 'INSERT', 'UPDATE', or 'DELETE'
        and (subs.action_filter = '*' or subs.action_filter = action::text);

-- Subscription vars
roles regrole[] = array_agg(distinct us.claims_role::text)
    from
        unnest(subscriptions) us;

working_role regrole;
claimed_role regrole;
claims jsonb;

subscription_id uuid;
subscription_has_access bool;
visible_to_subscription_ids uuid[] = '{}';

-- structured info for wal's columns
columns realtime.wal_column[];
-- previous identity values for update/delete
old_columns realtime.wal_column[];

error_record_exceeds_max_size boolean = octet_length(wal::text) > max_record_bytes;

-- Primary jsonb output for record
output jsonb;

begin
perform set_config('role', null, true);

columns =
    array_agg(
        (
            x->>'name',
            x->>'type',
            x->>'typeoid',
            realtime.cast(
                (x->'value') #>> '{}',
                coalesce(
                    (x->>'typeoid')::regtype, -- null when wal2json version <= 2.4
                    (x->>'type')::regtype
                )
            ),
            (pks ->> 'name') is not null,
            true
        )::realtime.wal_column
    )
    from
        jsonb_array_elements(wal -> 'columns') x
        left join jsonb_array_elements(wal -> 'pk') pks
            on (x ->> 'name') = (pks ->> 'name');

old_columns =
    array_agg(
        (
            x->>'name',
            x->>'type',
            x->>'typeoid',
            realtime.cast(
                (x->'value') #>> '{}',
                coalesce(
                    (x->>'typeoid')::regtype, -- null when wal2json version <= 2.4
                    (x->>'type')::regtype
                )
            ),
            (pks ->> 'name') is not null,
            true
        )::realtime.wal_column
    )
    from
        jsonb_array_elements(wal -> 'identity') x
        left join jsonb_array_elements(wal -> 'pk') pks
            on (x ->> 'name') = (pks ->> 'name');

for working_role in select * from unnest(roles) loop

    -- Update `is_selectable` for columns and old_columns
    columns =
        array_agg(
            (
                c.name,
                c.type_name,
                c.type_oid,
                c.value,
                c.is_pkey,
                pg_catalog.has_column_privilege(working_role, entity_, c.name, 'SELECT')
            )::realtime.wal_column
        )
        from
            unnest(columns) c;

    old_columns =
            array_agg(
                (
                    c.name,
                    c.type_name,
                    c.type_oid,
                    c.value,
                    c.is_pkey,
                    pg_catalog.has_column_privilege(working_role, entity_, c.name, 'SELECT')
                )::realtime.wal_column
            )
            from
                unnest(old_columns) c;

    if action <> 'DELETE' and count(1) = 0 from unnest(columns) c where c.is_pkey then
        return next (
            jsonb_build_object(
                'schema', wal ->> 'schema',
                'table', wal ->> 'table',
                'type', action
            ),
            is_rls_enabled,
            -- subscriptions is already filtered by entity
            (select array_agg(s.subscription_id) from unnest(subscriptions) as s where claims_role = working_role),
            array['Error 400: Bad Request, no primary key']
        )::realtime.wal_rls;

    -- The claims role does not have SELECT permission to the primary key of entity
    elsif action <> 'DELETE' and sum(c.is_selectable::int) <> count(1) from unnest(columns) c where c.is_pkey then
        return next (
            jsonb_build_object(
                'schema', wal ->> 'schema',
                'table', wal ->> 'table',
                'type', action
            ),
            is_rls_enabled,
            (select array_agg(s.subscription_id) from unnest(subscriptions) as s where claims_role = working_role),
            array['Error 401: Unauthorized']
        )::realtime.wal_rls;

    else
        output = jsonb_build_object(
            'schema', wal ->> 'schema',
            'table', wal ->> 'table',
            'type', action,
            'commit_timestamp', to_char(
                ((wal ->> 'timestamp')::timestamptz at time zone 'utc'),
                'YYYY-MM-DD"T"HH24:MI:SS.MS"Z"'
            ),
            'columns', (
                select
                    jsonb_agg(
                        jsonb_build_object(
                            'name', pa.attname,
                            'type', pt.typname
                        )
                        order by pa.attnum asc
                    )
                from
                    pg_attribute pa
                    join pg_type pt
                        on pa.atttypid = pt.oid
                where
                    attrelid = entity_
                    and attnum > 0
                    and pg_catalog.has_column_privilege(working_role, entity_, pa.attname, 'SELECT')
            )
        )
        -- Add "record" key for insert and update
        || case
            when action in ('INSERT', 'UPDATE') then
                jsonb_build_object(
                    'record',
                    (
                        select
                            jsonb_object_agg(
                                -- if unchanged toast, get column name and value from old record
                                coalesce((c).name, (oc).name),
                                case
                                    when (c).name is null then (oc).value
                                    else (c).value
                                end
                            )
                        from
                            unnest(columns) c
                            full outer join unnest(old_columns) oc
                                on (c).name = (oc).name
                        where
                            coalesce((c).is_selectable, (oc).is_selectable)
                            and ( not error_record_exceeds_max_size or (octet_length((c).value::text) <= 64))
                    )
                )
            else '{}'::jsonb
        end
        -- Add "old_record" key for update and delete
        || case
            when action = 'UPDATE' then
                jsonb_build_object(
                        'old_record',
                        (
                            select jsonb_object_agg((c).name, (c).value)
                            from unnest(old_columns) c
                            where
                                (c).is_selectable
                                and ( not error_record_exceeds_max_size or (octet_length((c).value::text) <= 64))
                        )
                    )
            when action = 'DELETE' then
                jsonb_build_object(
                    'old_record',
                    (
                        select jsonb_object_agg((c).name, (c).value)
                        from unnest(old_columns) c
                        where
                            (c).is_selectable
                            and ( not error_record_exceeds_max_size or (octet_length((c).value::text) <= 64))
                            and ( not is_rls_enabled or (c).is_pkey ) -- if RLS enabled, we can't secure deletes so filter to pkey
                    )
                )
            else '{}'::jsonb
        end;

        -- Create the prepared statement
        if is_rls_enabled and action <> 'DELETE' then
            if (select 1 from pg_prepared_statements where name = 'walrus_rls_stmt' limit 1) > 0 then
                deallocate walrus_rls_stmt;
            end if;
            execute realtime.build_prepared_statement_sql('walrus_rls_stmt', entity_, columns);
        end if;

        visible_to_subscription_ids = '{}';

        for subscription_id, claims in (
                select
                    subs.subscription_id,
                    subs.claims
                from
                    unnest(subscriptions) subs
                where
                    subs.entity = entity_
                    and subs.claims_role = working_role
                    and (
                        realtime.is_visible_through_filters(columns, subs.filters)
                        or (
                          action = 'DELETE'
                          and realtime.is_visible_through_filters(old_columns, subs.filters)
                        )
                    )
        ) loop

            if not is_rls_enabled or action = 'DELETE' then
                visible_to_subscription_ids = visible_to_subscription_ids || subscription_id;
            else
                -- Check if RLS allows the role to see the record
                perform
                    -- Trim leading and trailing quotes from working_role because set_config
                    -- doesn't recognize the role as valid if they are included
                    set_config('role', trim(both '"' from working_role::text), true),
                    set_config('request.jwt.claims', claims::text, true);

                execute 'execute walrus_rls_stmt' into subscription_has_access;

                if subscription_has_access then
                    visible_to_subscription_ids = visible_to_subscription_ids || subscription_id;
                end if;
            end if;
        end loop;

        perform set_config('role', null, true);

        return next (
            output,
            is_rls_enabled,
            visible_to_subscription_ids,
            case
                when error_record_exceeds_max_size then array['Error 413: Payload Too Large']
                else '{}'
            end
        )::realtime.wal_rls;

    end if;
end loop;

perform set_config('role', null, true);
end;
$$;


ALTER FUNCTION realtime.apply_rls(wal jsonb, max_record_bytes integer) OWNER TO postgres;

--
-- TOC entry 361 (class 1255 OID 33843)
-- Name: broadcast_changes(text, text, text, text, text, record, record, text); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.broadcast_changes(topic_name text, event_name text, operation text, table_name text, table_schema text, new record, old record, level text DEFAULT 'ROW'::text) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
    -- Declare a variable to hold the JSONB representation of the row
    row_data jsonb := '{}'::jsonb;
BEGIN
    IF level = 'STATEMENT' THEN
        RAISE EXCEPTION 'function can only be triggered for each row, not for each statement';
    END IF;
    -- Check the operation type and handle accordingly
    IF operation = 'INSERT' OR operation = 'UPDATE' OR operation = 'DELETE' THEN
        row_data := jsonb_build_object('old_record', OLD, 'record', NEW, 'operation', operation, 'table', table_name, 'schema', table_schema);
        PERFORM realtime.send (row_data, event_name, topic_name);
    ELSE
        RAISE EXCEPTION 'Unexpected operation type: %', operation;
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        RAISE EXCEPTION 'Failed to process the row: %', SQLERRM;
END;

$$;


ALTER FUNCTION realtime.broadcast_changes(topic_name text, event_name text, operation text, table_name text, table_schema text, new record, old record, level text) OWNER TO postgres;

--
-- TOC entry 335 (class 1255 OID 33844)
-- Name: build_prepared_statement_sql(text, regclass, realtime.wal_column[]); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.build_prepared_statement_sql(prepared_statement_name text, entity regclass, columns realtime.wal_column[]) RETURNS text
    LANGUAGE sql
    AS $$
      /*
      Builds a sql string that, if executed, creates a prepared statement to
      tests retrive a row from *entity* by its primary key columns.
      Example
          select realtime.build_prepared_statement_sql('public.notes', '{"id"}'::text[], '{"bigint"}'::text[])
      */
          select
      'prepare ' || prepared_statement_name || ' as
          select
              exists(
                  select
                      1
                  from
                      ' || entity || '
                  where
                      ' || string_agg(quote_ident(pkc.name) || '=' || quote_nullable(pkc.value #>> '{}') , ' and ') || '
              )'
          from
              unnest(columns) pkc
          where
              pkc.is_pkey
          group by
              entity
      $$;


ALTER FUNCTION realtime.build_prepared_statement_sql(prepared_statement_name text, entity regclass, columns realtime.wal_column[]) OWNER TO postgres;

--
-- TOC entry 311 (class 1255 OID 33845)
-- Name: cast(text, regtype); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime."cast"(val text, type_ regtype) RETURNS jsonb
    LANGUAGE plpgsql IMMUTABLE
    AS $$
declare
  res jsonb;
begin
  if type_::text = 'bytea' then
    return to_jsonb(val);
  end if;
  execute format('select to_jsonb(%L::'|| type_::text || ')', val) into res;
  return res;
end
$$;


ALTER FUNCTION realtime."cast"(val text, type_ regtype) OWNER TO postgres;

--
-- TOC entry 352 (class 1255 OID 33846)
-- Name: check_equality_op(realtime.equality_op, regtype, text, text); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.check_equality_op(op realtime.equality_op, type_ regtype, val_1 text, val_2 text) RETURNS boolean
    LANGUAGE plpgsql IMMUTABLE
    AS $$
      /*
      Casts *val_1* and *val_2* as type *type_* and check the *op* condition for truthiness
      */
      declare
          op_symbol text = (
              case
                  when op = 'eq' then '='
                  when op = 'neq' then '!='
                  when op = 'lt' then '<'
                  when op = 'lte' then '<='
                  when op = 'gt' then '>'
                  when op = 'gte' then '>='
                  when op = 'in' then '= any'
                  else 'UNKNOWN OP'
              end
          );
          res boolean;
      begin
          execute format(
              'select %L::'|| type_::text || ' ' || op_symbol
              || ' ( %L::'
              || (
                  case
                      when op = 'in' then type_::text || '[]'
                      else type_::text end
              )
              || ')', val_1, val_2) into res;
          return res;
      end;
      $$;


ALTER FUNCTION realtime.check_equality_op(op realtime.equality_op, type_ regtype, val_1 text, val_2 text) OWNER TO postgres;

--
-- TOC entry 332 (class 1255 OID 33847)
-- Name: is_visible_through_filters(realtime.wal_column[], realtime.user_defined_filter[]); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.is_visible_through_filters(columns realtime.wal_column[], filters realtime.user_defined_filter[]) RETURNS boolean
    LANGUAGE sql IMMUTABLE
    AS $_$
    /*
    Should the record be visible (true) or filtered out (false) after *filters* are applied
    */
        select
            -- Default to allowed when no filters present
            $2 is null -- no filters. this should not happen because subscriptions has a default
            or array_length($2, 1) is null -- array length of an empty array is null
            or bool_and(
                coalesce(
                    realtime.check_equality_op(
                        op:=f.op,
                        type_:=coalesce(
                            col.type_oid::regtype, -- null when wal2json version <= 2.4
                            col.type_name::regtype
                        ),
                        -- cast jsonb to text
                        val_1:=col.value #>> '{}',
                        val_2:=f.value
                    ),
                    false -- if null, filter does not match
                )
            )
        from
            unnest(filters) f
            join unnest(columns) col
                on f.column_name = col.name;
    $_$;


ALTER FUNCTION realtime.is_visible_through_filters(columns realtime.wal_column[], filters realtime.user_defined_filter[]) OWNER TO postgres;

--
-- TOC entry 386 (class 1255 OID 33848)
-- Name: list_changes(name, name, integer, integer); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.list_changes(publication name, slot_name name, max_changes integer, max_record_bytes integer) RETURNS TABLE(wal jsonb, is_rls_enabled boolean, subscription_ids uuid[], errors text[], slot_changes_count bigint)
    LANGUAGE sql
    SET log_min_messages TO 'fatal'
    AS $$
  WITH pub AS (
    SELECT
      concat_ws(
        ',',
        CASE WHEN bool_or(pubinsert) THEN 'insert' ELSE NULL END,
        CASE WHEN bool_or(pubupdate) THEN 'update' ELSE NULL END,
        CASE WHEN bool_or(pubdelete) THEN 'delete' ELSE NULL END
      ) AS w2j_actions,
      coalesce(
        string_agg(
          realtime.quote_wal2json(format('%I.%I', schemaname, tablename)::regclass),
          ','
        ) filter (WHERE ppt.tablename IS NOT NULL AND ppt.tablename NOT LIKE '% %'),
        ''
      ) AS w2j_add_tables
    FROM pg_publication pp
    LEFT JOIN pg_publication_tables ppt ON pp.pubname = ppt.pubname
    WHERE pp.pubname = publication
    GROUP BY pp.pubname
    LIMIT 1
  ),
  -- MATERIALIZED ensures pg_logical_slot_get_changes is called exactly once
  w2j AS MATERIALIZED (
    SELECT x.*, pub.w2j_add_tables
    FROM pub,
         pg_logical_slot_get_changes(
           slot_name, null, max_changes,
           'include-pk', 'true',
           'include-transaction', 'false',
           'include-timestamp', 'true',
           'include-type-oids', 'true',
           'format-version', '2',
           'actions', pub.w2j_actions,
           'add-tables', pub.w2j_add_tables
         ) x
  ),
  -- Count raw slot entries before apply_rls/subscription filter
  slot_count AS (
    SELECT count(*)::bigint AS cnt
    FROM w2j
    WHERE w2j.w2j_add_tables <> ''
  ),
  -- Apply RLS and filter as before
  rls_filtered AS (
    SELECT xyz.wal, xyz.is_rls_enabled, xyz.subscription_ids, xyz.errors
    FROM w2j,
         realtime.apply_rls(
           wal := w2j.data::jsonb,
           max_record_bytes := max_record_bytes
         ) xyz(wal, is_rls_enabled, subscription_ids, errors)
    WHERE w2j.w2j_add_tables <> ''
      AND xyz.subscription_ids[1] IS NOT NULL
  )
  -- Real rows with slot count attached
  SELECT rf.wal, rf.is_rls_enabled, rf.subscription_ids, rf.errors, sc.cnt
  FROM rls_filtered rf, slot_count sc

  UNION ALL

  -- Sentinel row: always returned when no real rows exist so Elixir can
  -- always read slot_changes_count. Identified by wal IS NULL.
  SELECT null, null, null, null, sc.cnt
  FROM slot_count sc
  WHERE NOT EXISTS (SELECT 1 FROM rls_filtered)
$$;


ALTER FUNCTION realtime.list_changes(publication name, slot_name name, max_changes integer, max_record_bytes integer) OWNER TO postgres;

--
-- TOC entry 350 (class 1255 OID 33849)
-- Name: quote_wal2json(regclass); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.quote_wal2json(entity regclass) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $$
      select
        (
          select string_agg('' || ch,'')
          from unnest(string_to_array(nsp.nspname::text, null)) with ordinality x(ch, idx)
          where
            not (x.idx = 1 and x.ch = '"')
            and not (
              x.idx = array_length(string_to_array(nsp.nspname::text, null), 1)
              and x.ch = '"'
            )
        )
        || '.'
        || (
          select string_agg('' || ch,'')
          from unnest(string_to_array(pc.relname::text, null)) with ordinality x(ch, idx)
          where
            not (x.idx = 1 and x.ch = '"')
            and not (
              x.idx = array_length(string_to_array(nsp.nspname::text, null), 1)
              and x.ch = '"'
            )
          )
      from
        pg_class pc
        join pg_namespace nsp
          on pc.relnamespace = nsp.oid
      where
        pc.oid = entity
    $$;


ALTER FUNCTION realtime.quote_wal2json(entity regclass) OWNER TO postgres;

--
-- TOC entry 348 (class 1255 OID 33850)
-- Name: send(jsonb, text, text, boolean); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.send(payload jsonb, event text, topic text, private boolean DEFAULT true) RETURNS void
    LANGUAGE plpgsql
    AS $$
DECLARE
  generated_id uuid;
  final_payload jsonb;
BEGIN
  BEGIN
    -- Generate a new UUID for the id
    generated_id := gen_random_uuid();

    -- Check if payload has an 'id' key, if not, add the generated UUID
    IF payload ? 'id' THEN
      final_payload := payload;
    ELSE
      final_payload := jsonb_set(payload, '{id}', to_jsonb(generated_id));
    END IF;

    -- Set the topic configuration
    EXECUTE format('SET LOCAL realtime.topic TO %L', topic);

    -- Attempt to insert the message
    INSERT INTO realtime.messages (id, payload, event, topic, private, extension)
    VALUES (generated_id, final_payload, event, topic, private, 'broadcast');
  EXCEPTION
    WHEN OTHERS THEN
      -- Capture and notify the error
      RAISE WARNING 'ErrorSendingBroadcastMessage: %', SQLERRM;
  END;
END;
$$;


ALTER FUNCTION realtime.send(payload jsonb, event text, topic text, private boolean) OWNER TO postgres;

--
-- TOC entry 372 (class 1255 OID 33851)
-- Name: subscription_check_filters(); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.subscription_check_filters() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    /*
    Validates that the user defined filters for a subscription:
    - refer to valid columns that the claimed role may access
    - values are coercable to the correct column type
    */
    declare
        col_names text[] = coalesce(
                array_agg(c.column_name order by c.ordinal_position),
                '{}'::text[]
            )
            from
                information_schema.columns c
            where
                format('%I.%I', c.table_schema, c.table_name)::regclass = new.entity
                and pg_catalog.has_column_privilege(
                    (new.claims ->> 'role'),
                    format('%I.%I', c.table_schema, c.table_name)::regclass,
                    c.column_name,
                    'SELECT'
                );
        filter realtime.user_defined_filter;
        col_type regtype;

        in_val jsonb;
    begin
        for filter in select * from unnest(new.filters) loop
            -- Filtered column is valid
            if not filter.column_name = any(col_names) then
                raise exception 'invalid column for filter %', filter.column_name;
            end if;

            -- Type is sanitized and safe for string interpolation
            col_type = (
                select atttypid::regtype
                from pg_catalog.pg_attribute
                where attrelid = new.entity
                      and attname = filter.column_name
            );
            if col_type is null then
                raise exception 'failed to lookup type for column %', filter.column_name;
            end if;

            -- Set maximum number of entries for in filter
            if filter.op = 'in'::realtime.equality_op then
                in_val = realtime.cast(filter.value, (col_type::text || '[]')::regtype);
                if coalesce(jsonb_array_length(in_val), 0) > 100 then
                    raise exception 'too many values for `in` filter. Maximum 100';
                end if;
            else
                -- raises an exception if value is not coercable to type
                perform realtime.cast(filter.value, col_type);
            end if;

        end loop;

        -- Apply consistent order to filters so the unique constraint on
        -- (subscription_id, entity, filters) can't be tricked by a different filter order
        new.filters = coalesce(
            array_agg(f order by f.column_name, f.op, f.value),
            '{}'
        ) from unnest(new.filters) f;

        return new;
    end;
    $$;


ALTER FUNCTION realtime.subscription_check_filters() OWNER TO postgres;

--
-- TOC entry 393 (class 1255 OID 33852)
-- Name: to_regrole(text); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.to_regrole(role_name text) RETURNS regrole
    LANGUAGE sql IMMUTABLE
    AS $$ select role_name::regrole $$;


ALTER FUNCTION realtime.to_regrole(role_name text) OWNER TO postgres;

--
-- TOC entry 407 (class 1255 OID 33853)
-- Name: topic(); Type: FUNCTION; Schema: realtime; Owner: postgres
--

CREATE FUNCTION realtime.topic() RETURNS text
    LANGUAGE sql STABLE
    AS $$
select nullif(current_setting('realtime.topic', true), '')::text;
$$;


ALTER FUNCTION realtime.topic() OWNER TO postgres;

--
-- TOC entry 338 (class 1255 OID 33854)
-- Name: allow_any_operation(text[]); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.allow_any_operation(expected_operations text[]) RETURNS boolean
    LANGUAGE sql STABLE
    AS $$
  WITH current_operation AS (
    SELECT storage.operation() AS raw_operation
  ),
  normalized AS (
    SELECT CASE
      WHEN raw_operation LIKE 'storage.%' THEN substr(raw_operation, 9)
      ELSE raw_operation
    END AS current_operation
    FROM current_operation
  )
  SELECT EXISTS (
    SELECT 1
    FROM normalized n
    CROSS JOIN LATERAL unnest(expected_operations) AS expected_operation
    WHERE expected_operation IS NOT NULL
      AND expected_operation <> ''
      AND n.current_operation = CASE
        WHEN expected_operation LIKE 'storage.%' THEN substr(expected_operation, 9)
        ELSE expected_operation
      END
  );
$$;


ALTER FUNCTION storage.allow_any_operation(expected_operations text[]) OWNER TO postgres;

--
-- TOC entry 343 (class 1255 OID 33855)
-- Name: allow_only_operation(text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.allow_only_operation(expected_operation text) RETURNS boolean
    LANGUAGE sql STABLE
    AS $$
  WITH current_operation AS (
    SELECT storage.operation() AS raw_operation
  ),
  normalized AS (
    SELECT
      CASE
        WHEN raw_operation LIKE 'storage.%' THEN substr(raw_operation, 9)
        ELSE raw_operation
      END AS current_operation,
      CASE
        WHEN expected_operation LIKE 'storage.%' THEN substr(expected_operation, 9)
        ELSE expected_operation
      END AS requested_operation
    FROM current_operation
  )
  SELECT CASE
    WHEN requested_operation IS NULL OR requested_operation = '' THEN FALSE
    ELSE COALESCE(current_operation = requested_operation, FALSE)
  END
  FROM normalized;
$$;


ALTER FUNCTION storage.allow_only_operation(expected_operation text) OWNER TO postgres;

--
-- TOC entry 378 (class 1255 OID 33856)
-- Name: can_insert_object(text, text, uuid, jsonb); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.can_insert_object(bucketid text, name text, owner uuid, metadata jsonb) RETURNS void
    LANGUAGE plpgsql
    AS $$
BEGIN
  INSERT INTO "storage"."objects" ("bucket_id", "name", "owner", "metadata") VALUES (bucketid, name, owner, metadata);
  -- hack to rollback the successful insert
  RAISE sqlstate 'PT200' using
  message = 'ROLLBACK',
  detail = 'rollback successful insert';
END
$$;


ALTER FUNCTION storage.can_insert_object(bucketid text, name text, owner uuid, metadata jsonb) OWNER TO postgres;

--
-- TOC entry 307 (class 1255 OID 33857)
-- Name: enforce_bucket_name_length(); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.enforce_bucket_name_length() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
    if length(new.name) > 100 then
        raise exception 'bucket name "%" is too long (% characters). Max is 100.', new.name, length(new.name);
    end if;
    return new;
end;
$$;


ALTER FUNCTION storage.enforce_bucket_name_length() OWNER TO postgres;

--
-- TOC entry 321 (class 1255 OID 33858)
-- Name: extension(text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.extension(name text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
_parts text[];
_filename text;
BEGIN
	select string_to_array(name, '/') into _parts;
	select _parts[array_length(_parts,1)] into _filename;
	-- @todo return the last part instead of 2
	return reverse(split_part(reverse(_filename), '.', 1));
END
$$;


ALTER FUNCTION storage.extension(name text) OWNER TO postgres;

--
-- TOC entry 404 (class 1255 OID 33859)
-- Name: filename(text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.filename(name text) RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
_parts text[];
BEGIN
	select string_to_array(name, '/') into _parts;
	return _parts[array_length(_parts,1)];
END
$$;


ALTER FUNCTION storage.filename(name text) OWNER TO postgres;

--
-- TOC entry 310 (class 1255 OID 33860)
-- Name: foldername(text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.foldername(name text) RETURNS text[]
    LANGUAGE plpgsql
    AS $$
DECLARE
_parts text[];
BEGIN
	select string_to_array(name, '/') into _parts;
	return _parts[1:array_length(_parts,1)-1];
END
$$;


ALTER FUNCTION storage.foldername(name text) OWNER TO postgres;

--
-- TOC entry 398 (class 1255 OID 33861)
-- Name: get_common_prefix(text, text, text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.get_common_prefix(p_key text, p_prefix text, p_delimiter text) RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$
SELECT CASE
    WHEN position(p_delimiter IN substring(p_key FROM length(p_prefix) + 1)) > 0
    THEN left(p_key, length(p_prefix) + position(p_delimiter IN substring(p_key FROM length(p_prefix) + 1)))
    ELSE NULL
END;
$$;


ALTER FUNCTION storage.get_common_prefix(p_key text, p_prefix text, p_delimiter text) OWNER TO postgres;

--
-- TOC entry 371 (class 1255 OID 33862)
-- Name: get_size_by_bucket(); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.get_size_by_bucket() RETURNS TABLE(size bigint, bucket_id text)
    LANGUAGE plpgsql
    AS $$
BEGIN
    return query
        select sum((metadata->>'size')::int) as size, obj.bucket_id
        from "storage".objects as obj
        group by obj.bucket_id;
END
$$;


ALTER FUNCTION storage.get_size_by_bucket() OWNER TO postgres;

--
-- TOC entry 382 (class 1255 OID 33863)
-- Name: list_multipart_uploads_with_delimiter(text, text, text, integer, text, text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.list_multipart_uploads_with_delimiter(bucket_id text, prefix_param text, delimiter_param text, max_keys integer DEFAULT 100, next_key_token text DEFAULT ''::text, next_upload_token text DEFAULT ''::text) RETURNS TABLE(key text, id text, created_at timestamp with time zone)
    LANGUAGE plpgsql
    AS $_$
BEGIN
    RETURN QUERY EXECUTE
        'SELECT DISTINCT ON(key COLLATE "C") * from (
            SELECT
                CASE
                    WHEN position($2 IN substring(key from length($1) + 1)) > 0 THEN
                        substring(key from 1 for length($1) + position($2 IN substring(key from length($1) + 1)))
                    ELSE
                        key
                END AS key, id, created_at
            FROM
                storage.s3_multipart_uploads
            WHERE
                bucket_id = $5 AND
                key ILIKE $1 || ''%'' AND
                CASE
                    WHEN $4 != '''' AND $6 = '''' THEN
                        CASE
                            WHEN position($2 IN substring(key from length($1) + 1)) > 0 THEN
                                substring(key from 1 for length($1) + position($2 IN substring(key from length($1) + 1))) COLLATE "C" > $4
                            ELSE
                                key COLLATE "C" > $4
                            END
                    ELSE
                        true
                END AND
                CASE
                    WHEN $6 != '''' THEN
                        id COLLATE "C" > $6
                    ELSE
                        true
                    END
            ORDER BY
                key COLLATE "C" ASC, created_at ASC) as e order by key COLLATE "C" LIMIT $3'
        USING prefix_param, delimiter_param, max_keys, next_key_token, bucket_id, next_upload_token;
END;
$_$;


ALTER FUNCTION storage.list_multipart_uploads_with_delimiter(bucket_id text, prefix_param text, delimiter_param text, max_keys integer, next_key_token text, next_upload_token text) OWNER TO postgres;

--
-- TOC entry 336 (class 1255 OID 33864)
-- Name: list_objects_with_delimiter(text, text, text, integer, text, text, text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.list_objects_with_delimiter(_bucket_id text, prefix_param text, delimiter_param text, max_keys integer DEFAULT 100, start_after text DEFAULT ''::text, next_token text DEFAULT ''::text, sort_order text DEFAULT 'asc'::text) RETURNS TABLE(name text, id uuid, metadata jsonb, updated_at timestamp with time zone, created_at timestamp with time zone, last_accessed_at timestamp with time zone)
    LANGUAGE plpgsql STABLE
    AS $_$
DECLARE
    v_peek_name TEXT;
    v_current RECORD;
    v_common_prefix TEXT;

    -- Configuration
    v_is_asc BOOLEAN;
    v_prefix TEXT;
    v_start TEXT;
    v_upper_bound TEXT;
    v_file_batch_size INT;

    -- Seek state
    v_next_seek TEXT;
    v_count INT := 0;

    -- Dynamic SQL for batch query only
    v_batch_query TEXT;

BEGIN
    -- ========================================================================
    -- INITIALIZATION
    -- ========================================================================
    v_is_asc := lower(coalesce(sort_order, 'asc')) = 'asc';
    v_prefix := coalesce(prefix_param, '');
    v_start := CASE WHEN coalesce(next_token, '') <> '' THEN next_token ELSE coalesce(start_after, '') END;
    v_file_batch_size := LEAST(GREATEST(max_keys * 2, 100), 1000);

    -- Calculate upper bound for prefix filtering (bytewise, using COLLATE "C")
    IF v_prefix = '' THEN
        v_upper_bound := NULL;
    ELSIF right(v_prefix, 1) = delimiter_param THEN
        v_upper_bound := left(v_prefix, -1) || chr(ascii(delimiter_param) + 1);
    ELSE
        v_upper_bound := left(v_prefix, -1) || chr(ascii(right(v_prefix, 1)) + 1);
    END IF;

    -- Build batch query (dynamic SQL - called infrequently, amortized over many rows)
    IF v_is_asc THEN
        IF v_upper_bound IS NOT NULL THEN
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND o.name COLLATE "C" >= $2 ' ||
                'AND o.name COLLATE "C" < $3 ORDER BY o.name COLLATE "C" ASC LIMIT $4';
        ELSE
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND o.name COLLATE "C" >= $2 ' ||
                'ORDER BY o.name COLLATE "C" ASC LIMIT $4';
        END IF;
    ELSE
        IF v_upper_bound IS NOT NULL THEN
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND o.name COLLATE "C" < $2 ' ||
                'AND o.name COLLATE "C" >= $3 ORDER BY o.name COLLATE "C" DESC LIMIT $4';
        ELSE
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND o.name COLLATE "C" < $2 ' ||
                'ORDER BY o.name COLLATE "C" DESC LIMIT $4';
        END IF;
    END IF;

    -- ========================================================================
    -- SEEK INITIALIZATION: Determine starting position
    -- ========================================================================
    IF v_start = '' THEN
        IF v_is_asc THEN
            v_next_seek := v_prefix;
        ELSE
            -- DESC without cursor: find the last item in range
            IF v_upper_bound IS NOT NULL THEN
                SELECT o.name INTO v_next_seek FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" >= v_prefix AND o.name COLLATE "C" < v_upper_bound
                ORDER BY o.name COLLATE "C" DESC LIMIT 1;
            ELSIF v_prefix <> '' THEN
                SELECT o.name INTO v_next_seek FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" >= v_prefix
                ORDER BY o.name COLLATE "C" DESC LIMIT 1;
            ELSE
                SELECT o.name INTO v_next_seek FROM storage.objects o
                WHERE o.bucket_id = _bucket_id
                ORDER BY o.name COLLATE "C" DESC LIMIT 1;
            END IF;

            IF v_next_seek IS NOT NULL THEN
                v_next_seek := v_next_seek || delimiter_param;
            ELSE
                RETURN;
            END IF;
        END IF;
    ELSE
        -- Cursor provided: determine if it refers to a folder or leaf
        IF EXISTS (
            SELECT 1 FROM storage.objects o
            WHERE o.bucket_id = _bucket_id
              AND o.name COLLATE "C" LIKE v_start || delimiter_param || '%'
            LIMIT 1
        ) THEN
            -- Cursor refers to a folder
            IF v_is_asc THEN
                v_next_seek := v_start || chr(ascii(delimiter_param) + 1);
            ELSE
                v_next_seek := v_start || delimiter_param;
            END IF;
        ELSE
            -- Cursor refers to a leaf object
            IF v_is_asc THEN
                v_next_seek := v_start || delimiter_param;
            ELSE
                v_next_seek := v_start;
            END IF;
        END IF;
    END IF;

    -- ========================================================================
    -- MAIN LOOP: Hybrid peek-then-batch algorithm
    -- Uses STATIC SQL for peek (hot path) and DYNAMIC SQL for batch
    -- ========================================================================
    LOOP
        EXIT WHEN v_count >= max_keys;

        -- STEP 1: PEEK using STATIC SQL (plan cached, very fast)
        IF v_is_asc THEN
            IF v_upper_bound IS NOT NULL THEN
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" >= v_next_seek AND o.name COLLATE "C" < v_upper_bound
                ORDER BY o.name COLLATE "C" ASC LIMIT 1;
            ELSE
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" >= v_next_seek
                ORDER BY o.name COLLATE "C" ASC LIMIT 1;
            END IF;
        ELSE
            IF v_upper_bound IS NOT NULL THEN
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" < v_next_seek AND o.name COLLATE "C" >= v_prefix
                ORDER BY o.name COLLATE "C" DESC LIMIT 1;
            ELSIF v_prefix <> '' THEN
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" < v_next_seek AND o.name COLLATE "C" >= v_prefix
                ORDER BY o.name COLLATE "C" DESC LIMIT 1;
            ELSE
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = _bucket_id AND o.name COLLATE "C" < v_next_seek
                ORDER BY o.name COLLATE "C" DESC LIMIT 1;
            END IF;
        END IF;

        EXIT WHEN v_peek_name IS NULL;

        -- STEP 2: Check if this is a FOLDER or FILE
        v_common_prefix := storage.get_common_prefix(v_peek_name, v_prefix, delimiter_param);

        IF v_common_prefix IS NOT NULL THEN
            -- FOLDER: Emit and skip to next folder (no heap access needed)
            name := rtrim(v_common_prefix, delimiter_param);
            id := NULL;
            updated_at := NULL;
            created_at := NULL;
            last_accessed_at := NULL;
            metadata := NULL;
            RETURN NEXT;
            v_count := v_count + 1;

            -- Advance seek past the folder range
            IF v_is_asc THEN
                v_next_seek := left(v_common_prefix, -1) || chr(ascii(delimiter_param) + 1);
            ELSE
                v_next_seek := v_common_prefix;
            END IF;
        ELSE
            -- FILE: Batch fetch using DYNAMIC SQL (overhead amortized over many rows)
            -- For ASC: upper_bound is the exclusive upper limit (< condition)
            -- For DESC: prefix is the inclusive lower limit (>= condition)
            FOR v_current IN EXECUTE v_batch_query USING _bucket_id, v_next_seek,
                CASE WHEN v_is_asc THEN COALESCE(v_upper_bound, v_prefix) ELSE v_prefix END, v_file_batch_size
            LOOP
                v_common_prefix := storage.get_common_prefix(v_current.name, v_prefix, delimiter_param);

                IF v_common_prefix IS NOT NULL THEN
                    -- Hit a folder: exit batch, let peek handle it
                    v_next_seek := v_current.name;
                    EXIT;
                END IF;

                -- Emit file
                name := v_current.name;
                id := v_current.id;
                updated_at := v_current.updated_at;
                created_at := v_current.created_at;
                last_accessed_at := v_current.last_accessed_at;
                metadata := v_current.metadata;
                RETURN NEXT;
                v_count := v_count + 1;

                -- Advance seek past this file
                IF v_is_asc THEN
                    v_next_seek := v_current.name || delimiter_param;
                ELSE
                    v_next_seek := v_current.name;
                END IF;

                EXIT WHEN v_count >= max_keys;
            END LOOP;
        END IF;
    END LOOP;
END;
$_$;


ALTER FUNCTION storage.list_objects_with_delimiter(_bucket_id text, prefix_param text, delimiter_param text, max_keys integer, start_after text, next_token text, sort_order text) OWNER TO postgres;

--
-- TOC entry 366 (class 1255 OID 33866)
-- Name: operation(); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.operation() RETURNS text
    LANGUAGE plpgsql STABLE
    AS $$
BEGIN
    RETURN current_setting('storage.operation', true);
END;
$$;


ALTER FUNCTION storage.operation() OWNER TO postgres;

--
-- TOC entry 369 (class 1255 OID 33867)
-- Name: protect_delete(); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.protect_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Check if storage.allow_delete_query is set to 'true'
    IF COALESCE(current_setting('storage.allow_delete_query', true), 'false') != 'true' THEN
        RAISE EXCEPTION 'Direct deletion from storage tables is not allowed. Use the Storage API instead.'
            USING HINT = 'This prevents accidental data loss from orphaned objects.',
                  ERRCODE = '42501';
    END IF;
    RETURN NULL;
END;
$$;


ALTER FUNCTION storage.protect_delete() OWNER TO postgres;

--
-- TOC entry 309 (class 1255 OID 33868)
-- Name: search(text, text, integer, integer, integer, text, text, text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.search(prefix text, bucketname text, limits integer DEFAULT 100, levels integer DEFAULT 1, offsets integer DEFAULT 0, search text DEFAULT ''::text, sortcolumn text DEFAULT 'name'::text, sortorder text DEFAULT 'asc'::text) RETURNS TABLE(name text, id uuid, updated_at timestamp with time zone, created_at timestamp with time zone, last_accessed_at timestamp with time zone, metadata jsonb)
    LANGUAGE plpgsql STABLE
    AS $_$
DECLARE
    v_peek_name TEXT;
    v_current RECORD;
    v_common_prefix TEXT;
    v_delimiter CONSTANT TEXT := '/';

    -- Configuration
    v_limit INT;
    v_prefix TEXT;
    v_prefix_lower TEXT;
    v_is_asc BOOLEAN;
    v_order_by TEXT;
    v_sort_order TEXT;
    v_upper_bound TEXT;
    v_file_batch_size INT;

    -- Dynamic SQL for batch query only
    v_batch_query TEXT;

    -- Seek state
    v_next_seek TEXT;
    v_count INT := 0;
    v_skipped INT := 0;
BEGIN
    -- ========================================================================
    -- INITIALIZATION
    -- ========================================================================
    v_limit := LEAST(coalesce(limits, 100), 1500);
    v_prefix := coalesce(prefix, '') || coalesce(search, '');
    v_prefix_lower := lower(v_prefix);
    v_is_asc := lower(coalesce(sortorder, 'asc')) = 'asc';
    v_file_batch_size := LEAST(GREATEST(v_limit * 2, 100), 1000);

    -- Validate sort column
    CASE lower(coalesce(sortcolumn, 'name'))
        WHEN 'name' THEN v_order_by := 'name';
        WHEN 'updated_at' THEN v_order_by := 'updated_at';
        WHEN 'created_at' THEN v_order_by := 'created_at';
        WHEN 'last_accessed_at' THEN v_order_by := 'last_accessed_at';
        ELSE v_order_by := 'name';
    END CASE;

    v_sort_order := CASE WHEN v_is_asc THEN 'asc' ELSE 'desc' END;

    -- ========================================================================
    -- NON-NAME SORTING: Use path_tokens approach (unchanged)
    -- ========================================================================
    IF v_order_by != 'name' THEN
        RETURN QUERY EXECUTE format(
            $sql$
            WITH folders AS (
                SELECT path_tokens[$1] AS folder
                FROM storage.objects
                WHERE objects.name ILIKE $2 || '%%'
                  AND bucket_id = $3
                  AND array_length(objects.path_tokens, 1) <> $1
                GROUP BY folder
                ORDER BY folder %s
            )
            (SELECT folder AS "name",
                   NULL::uuid AS id,
                   NULL::timestamptz AS updated_at,
                   NULL::timestamptz AS created_at,
                   NULL::timestamptz AS last_accessed_at,
                   NULL::jsonb AS metadata FROM folders)
            UNION ALL
            (SELECT path_tokens[$1] AS "name",
                   id, updated_at, created_at, last_accessed_at, metadata
             FROM storage.objects
             WHERE objects.name ILIKE $2 || '%%'
               AND bucket_id = $3
               AND array_length(objects.path_tokens, 1) = $1
             ORDER BY %I %s)
            LIMIT $4 OFFSET $5
            $sql$, v_sort_order, v_order_by, v_sort_order
        ) USING levels, v_prefix, bucketname, v_limit, offsets;
        RETURN;
    END IF;

    -- ========================================================================
    -- NAME SORTING: Hybrid skip-scan with batch optimization
    -- ========================================================================

    -- Calculate upper bound for prefix filtering
    IF v_prefix_lower = '' THEN
        v_upper_bound := NULL;
    ELSIF right(v_prefix_lower, 1) = v_delimiter THEN
        v_upper_bound := left(v_prefix_lower, -1) || chr(ascii(v_delimiter) + 1);
    ELSE
        v_upper_bound := left(v_prefix_lower, -1) || chr(ascii(right(v_prefix_lower, 1)) + 1);
    END IF;

    -- Build batch query (dynamic SQL - called infrequently, amortized over many rows)
    IF v_is_asc THEN
        IF v_upper_bound IS NOT NULL THEN
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND lower(o.name) COLLATE "C" >= $2 ' ||
                'AND lower(o.name) COLLATE "C" < $3 ORDER BY lower(o.name) COLLATE "C" ASC LIMIT $4';
        ELSE
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND lower(o.name) COLLATE "C" >= $2 ' ||
                'ORDER BY lower(o.name) COLLATE "C" ASC LIMIT $4';
        END IF;
    ELSE
        IF v_upper_bound IS NOT NULL THEN
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND lower(o.name) COLLATE "C" < $2 ' ||
                'AND lower(o.name) COLLATE "C" >= $3 ORDER BY lower(o.name) COLLATE "C" DESC LIMIT $4';
        ELSE
            v_batch_query := 'SELECT o.name, o.id, o.updated_at, o.created_at, o.last_accessed_at, o.metadata ' ||
                'FROM storage.objects o WHERE o.bucket_id = $1 AND lower(o.name) COLLATE "C" < $2 ' ||
                'ORDER BY lower(o.name) COLLATE "C" DESC LIMIT $4';
        END IF;
    END IF;

    -- Initialize seek position
    IF v_is_asc THEN
        v_next_seek := v_prefix_lower;
    ELSE
        -- DESC: find the last item in range first (static SQL)
        IF v_upper_bound IS NOT NULL THEN
            SELECT o.name INTO v_peek_name FROM storage.objects o
            WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" >= v_prefix_lower AND lower(o.name) COLLATE "C" < v_upper_bound
            ORDER BY lower(o.name) COLLATE "C" DESC LIMIT 1;
        ELSIF v_prefix_lower <> '' THEN
            SELECT o.name INTO v_peek_name FROM storage.objects o
            WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" >= v_prefix_lower
            ORDER BY lower(o.name) COLLATE "C" DESC LIMIT 1;
        ELSE
            SELECT o.name INTO v_peek_name FROM storage.objects o
            WHERE o.bucket_id = bucketname
            ORDER BY lower(o.name) COLLATE "C" DESC LIMIT 1;
        END IF;

        IF v_peek_name IS NOT NULL THEN
            v_next_seek := lower(v_peek_name) || v_delimiter;
        ELSE
            RETURN;
        END IF;
    END IF;

    -- ========================================================================
    -- MAIN LOOP: Hybrid peek-then-batch algorithm
    -- Uses STATIC SQL for peek (hot path) and DYNAMIC SQL for batch
    -- ========================================================================
    LOOP
        EXIT WHEN v_count >= v_limit;

        -- STEP 1: PEEK using STATIC SQL (plan cached, very fast)
        IF v_is_asc THEN
            IF v_upper_bound IS NOT NULL THEN
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" >= v_next_seek AND lower(o.name) COLLATE "C" < v_upper_bound
                ORDER BY lower(o.name) COLLATE "C" ASC LIMIT 1;
            ELSE
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" >= v_next_seek
                ORDER BY lower(o.name) COLLATE "C" ASC LIMIT 1;
            END IF;
        ELSE
            IF v_upper_bound IS NOT NULL THEN
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" < v_next_seek AND lower(o.name) COLLATE "C" >= v_prefix_lower
                ORDER BY lower(o.name) COLLATE "C" DESC LIMIT 1;
            ELSIF v_prefix_lower <> '' THEN
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" < v_next_seek AND lower(o.name) COLLATE "C" >= v_prefix_lower
                ORDER BY lower(o.name) COLLATE "C" DESC LIMIT 1;
            ELSE
                SELECT o.name INTO v_peek_name FROM storage.objects o
                WHERE o.bucket_id = bucketname AND lower(o.name) COLLATE "C" < v_next_seek
                ORDER BY lower(o.name) COLLATE "C" DESC LIMIT 1;
            END IF;
        END IF;

        EXIT WHEN v_peek_name IS NULL;

        -- STEP 2: Check if this is a FOLDER or FILE
        v_common_prefix := storage.get_common_prefix(lower(v_peek_name), v_prefix_lower, v_delimiter);

        IF v_common_prefix IS NOT NULL THEN
            -- FOLDER: Handle offset, emit if needed, skip to next folder
            IF v_skipped < offsets THEN
                v_skipped := v_skipped + 1;
            ELSE
                name := split_part(rtrim(storage.get_common_prefix(v_peek_name, v_prefix, v_delimiter), v_delimiter), v_delimiter, levels);
                id := NULL;
                updated_at := NULL;
                created_at := NULL;
                last_accessed_at := NULL;
                metadata := NULL;
                RETURN NEXT;
                v_count := v_count + 1;
            END IF;

            -- Advance seek past the folder range
            IF v_is_asc THEN
                v_next_seek := lower(left(v_common_prefix, -1)) || chr(ascii(v_delimiter) + 1);
            ELSE
                v_next_seek := lower(v_common_prefix);
            END IF;
        ELSE
            -- FILE: Batch fetch using DYNAMIC SQL (overhead amortized over many rows)
            -- For ASC: upper_bound is the exclusive upper limit (< condition)
            -- For DESC: prefix_lower is the inclusive lower limit (>= condition)
            FOR v_current IN EXECUTE v_batch_query
                USING bucketname, v_next_seek,
                    CASE WHEN v_is_asc THEN COALESCE(v_upper_bound, v_prefix_lower) ELSE v_prefix_lower END, v_file_batch_size
            LOOP
                v_common_prefix := storage.get_common_prefix(lower(v_current.name), v_prefix_lower, v_delimiter);

                IF v_common_prefix IS NOT NULL THEN
                    -- Hit a folder: exit batch, let peek handle it
                    v_next_seek := lower(v_current.name);
                    EXIT;
                END IF;

                -- Handle offset skipping
                IF v_skipped < offsets THEN
                    v_skipped := v_skipped + 1;
                ELSE
                    -- Emit file
                    name := split_part(v_current.name, v_delimiter, levels);
                    id := v_current.id;
                    updated_at := v_current.updated_at;
                    created_at := v_current.created_at;
                    last_accessed_at := v_current.last_accessed_at;
                    metadata := v_current.metadata;
                    RETURN NEXT;
                    v_count := v_count + 1;
                END IF;

                -- Advance seek past this file
                IF v_is_asc THEN
                    v_next_seek := lower(v_current.name) || v_delimiter;
                ELSE
                    v_next_seek := lower(v_current.name);
                END IF;

                EXIT WHEN v_count >= v_limit;
            END LOOP;
        END IF;
    END LOOP;
END;
$_$;


ALTER FUNCTION storage.search(prefix text, bucketname text, limits integer, levels integer, offsets integer, search text, sortcolumn text, sortorder text) OWNER TO postgres;

--
-- TOC entry 392 (class 1255 OID 33870)
-- Name: search_by_timestamp(text, text, integer, integer, text, text, text, text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.search_by_timestamp(p_prefix text, p_bucket_id text, p_limit integer, p_level integer, p_start_after text, p_sort_order text, p_sort_column text, p_sort_column_after text) RETURNS TABLE(key text, name text, id uuid, updated_at timestamp with time zone, created_at timestamp with time zone, last_accessed_at timestamp with time zone, metadata jsonb)
    LANGUAGE plpgsql STABLE
    AS $_$
DECLARE
    v_cursor_op text;
    v_query text;
    v_prefix text;
BEGIN
    v_prefix := coalesce(p_prefix, '');

    IF p_sort_order = 'asc' THEN
        v_cursor_op := '>';
    ELSE
        v_cursor_op := '<';
    END IF;

    v_query := format($sql$
        WITH raw_objects AS (
            SELECT
                o.name AS obj_name,
                o.id AS obj_id,
                o.updated_at AS obj_updated_at,
                o.created_at AS obj_created_at,
                o.last_accessed_at AS obj_last_accessed_at,
                o.metadata AS obj_metadata,
                storage.get_common_prefix(o.name, $1, '/') AS common_prefix
            FROM storage.objects o
            WHERE o.bucket_id = $2
              AND o.name COLLATE "C" LIKE $1 || '%%'
        ),
        -- Aggregate common prefixes (folders)
        -- Both created_at and updated_at use MIN(obj_created_at) to match the old prefixes table behavior
        aggregated_prefixes AS (
            SELECT
                rtrim(common_prefix, '/') AS name,
                NULL::uuid AS id,
                MIN(obj_created_at) AS updated_at,
                MIN(obj_created_at) AS created_at,
                NULL::timestamptz AS last_accessed_at,
                NULL::jsonb AS metadata,
                TRUE AS is_prefix
            FROM raw_objects
            WHERE common_prefix IS NOT NULL
            GROUP BY common_prefix
        ),
        leaf_objects AS (
            SELECT
                obj_name AS name,
                obj_id AS id,
                obj_updated_at AS updated_at,
                obj_created_at AS created_at,
                obj_last_accessed_at AS last_accessed_at,
                obj_metadata AS metadata,
                FALSE AS is_prefix
            FROM raw_objects
            WHERE common_prefix IS NULL
        ),
        combined AS (
            SELECT * FROM aggregated_prefixes
            UNION ALL
            SELECT * FROM leaf_objects
        ),
        filtered AS (
            SELECT *
            FROM combined
            WHERE (
                $5 = ''
                OR ROW(
                    date_trunc('milliseconds', %I),
                    name COLLATE "C"
                ) %s ROW(
                    COALESCE(NULLIF($6, '')::timestamptz, 'epoch'::timestamptz),
                    $5
                )
            )
        )
        SELECT
            split_part(name, '/', $3) AS key,
            name,
            id,
            updated_at,
            created_at,
            last_accessed_at,
            metadata
        FROM filtered
        ORDER BY
            COALESCE(date_trunc('milliseconds', %I), 'epoch'::timestamptz) %s,
            name COLLATE "C" %s
        LIMIT $4
    $sql$,
        p_sort_column,
        v_cursor_op,
        p_sort_column,
        p_sort_order,
        p_sort_order
    );

    RETURN QUERY EXECUTE v_query
    USING v_prefix, p_bucket_id, p_level, p_limit, p_start_after, p_sort_column_after;
END;
$_$;


ALTER FUNCTION storage.search_by_timestamp(p_prefix text, p_bucket_id text, p_limit integer, p_level integer, p_start_after text, p_sort_order text, p_sort_column text, p_sort_column_after text) OWNER TO postgres;

--
-- TOC entry 359 (class 1255 OID 33871)
-- Name: search_v2(text, text, integer, integer, text, text, text, text); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.search_v2(prefix text, bucket_name text, limits integer DEFAULT 100, levels integer DEFAULT 1, start_after text DEFAULT ''::text, sort_order text DEFAULT 'asc'::text, sort_column text DEFAULT 'name'::text, sort_column_after text DEFAULT ''::text) RETURNS TABLE(key text, name text, id uuid, updated_at timestamp with time zone, created_at timestamp with time zone, last_accessed_at timestamp with time zone, metadata jsonb)
    LANGUAGE plpgsql STABLE
    AS $$
DECLARE
    v_sort_col text;
    v_sort_ord text;
    v_limit int;
BEGIN
    -- Cap limit to maximum of 1500 records
    v_limit := LEAST(coalesce(limits, 100), 1500);

    -- Validate and normalize sort_order
    v_sort_ord := lower(coalesce(sort_order, 'asc'));
    IF v_sort_ord NOT IN ('asc', 'desc') THEN
        v_sort_ord := 'asc';
    END IF;

    -- Validate and normalize sort_column
    v_sort_col := lower(coalesce(sort_column, 'name'));
    IF v_sort_col NOT IN ('name', 'updated_at', 'created_at') THEN
        v_sort_col := 'name';
    END IF;

    -- Route to appropriate implementation
    IF v_sort_col = 'name' THEN
        -- Use list_objects_with_delimiter for name sorting (most efficient: O(k * log n))
        RETURN QUERY
        SELECT
            split_part(l.name, '/', levels) AS key,
            l.name AS name,
            l.id,
            l.updated_at,
            l.created_at,
            l.last_accessed_at,
            l.metadata
        FROM storage.list_objects_with_delimiter(
            bucket_name,
            coalesce(prefix, ''),
            '/',
            v_limit,
            start_after,
            '',
            v_sort_ord
        ) l;
    ELSE
        -- Use aggregation approach for timestamp sorting
        -- Not efficient for large datasets but supports correct pagination
        RETURN QUERY SELECT * FROM storage.search_by_timestamp(
            prefix, bucket_name, v_limit, levels, start_after,
            v_sort_ord, v_sort_col, sort_column_after
        );
    END IF;
END;
$$;


ALTER FUNCTION storage.search_v2(prefix text, bucket_name text, limits integer, levels integer, start_after text, sort_order text, sort_column text, sort_column_after text) OWNER TO postgres;

--
-- TOC entry 353 (class 1255 OID 33872)
-- Name: update_updated_at_column(); Type: FUNCTION; Schema: storage; Owner: postgres
--

CREATE FUNCTION storage.update_updated_at_column() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = now();
    RETURN NEW; 
END;
$$;


ALTER FUNCTION storage.update_updated_at_column() OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 235 (class 1259 OID 33873)
-- Name: audit_log_entries; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.audit_log_entries (
    instance_id uuid,
    id uuid NOT NULL,
    payload json,
    created_at timestamp with time zone,
    ip_address character varying(64) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE auth.audit_log_entries OWNER TO postgres;

--
-- TOC entry 5914 (class 0 OID 0)
-- Dependencies: 235
-- Name: TABLE audit_log_entries; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.audit_log_entries IS 'Auth: Audit trail for user actions.';


--
-- TOC entry 236 (class 1259 OID 33881)
-- Name: custom_oauth_providers; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.custom_oauth_providers (
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    provider_type text NOT NULL,
    identifier text NOT NULL,
    name text NOT NULL,
    client_id text NOT NULL,
    client_secret text NOT NULL,
    acceptable_client_ids text[] DEFAULT '{}'::text[] NOT NULL,
    scopes text[] DEFAULT '{}'::text[] NOT NULL,
    pkce_enabled boolean DEFAULT true NOT NULL,
    attribute_mapping jsonb DEFAULT '{}'::jsonb NOT NULL,
    authorization_params jsonb DEFAULT '{}'::jsonb NOT NULL,
    enabled boolean DEFAULT true NOT NULL,
    email_optional boolean DEFAULT false NOT NULL,
    issuer text,
    discovery_url text,
    skip_nonce_check boolean DEFAULT false NOT NULL,
    cached_discovery jsonb,
    discovery_cached_at timestamp with time zone,
    authorization_url text,
    token_url text,
    userinfo_url text,
    jwks_uri text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    CONSTRAINT custom_oauth_providers_authorization_url_https CHECK (((authorization_url IS NULL) OR (authorization_url ~~ 'https://%'::text))),
    CONSTRAINT custom_oauth_providers_authorization_url_length CHECK (((authorization_url IS NULL) OR (char_length(authorization_url) <= 2048))),
    CONSTRAINT custom_oauth_providers_client_id_length CHECK (((char_length(client_id) >= 1) AND (char_length(client_id) <= 512))),
    CONSTRAINT custom_oauth_providers_discovery_url_length CHECK (((discovery_url IS NULL) OR (char_length(discovery_url) <= 2048))),
    CONSTRAINT custom_oauth_providers_identifier_format CHECK ((identifier ~ '^[a-z0-9][a-z0-9:-]{0,48}[a-z0-9]$'::text)),
    CONSTRAINT custom_oauth_providers_issuer_length CHECK (((issuer IS NULL) OR ((char_length(issuer) >= 1) AND (char_length(issuer) <= 2048)))),
    CONSTRAINT custom_oauth_providers_jwks_uri_https CHECK (((jwks_uri IS NULL) OR (jwks_uri ~~ 'https://%'::text))),
    CONSTRAINT custom_oauth_providers_jwks_uri_length CHECK (((jwks_uri IS NULL) OR (char_length(jwks_uri) <= 2048))),
    CONSTRAINT custom_oauth_providers_name_length CHECK (((char_length(name) >= 1) AND (char_length(name) <= 100))),
    CONSTRAINT custom_oauth_providers_oauth2_requires_endpoints CHECK (((provider_type <> 'oauth2'::text) OR ((authorization_url IS NOT NULL) AND (token_url IS NOT NULL) AND (userinfo_url IS NOT NULL)))),
    CONSTRAINT custom_oauth_providers_oidc_discovery_url_https CHECK (((provider_type <> 'oidc'::text) OR (discovery_url IS NULL) OR (discovery_url ~~ 'https://%'::text))),
    CONSTRAINT custom_oauth_providers_oidc_issuer_https CHECK (((provider_type <> 'oidc'::text) OR (issuer IS NULL) OR (issuer ~~ 'https://%'::text))),
    CONSTRAINT custom_oauth_providers_oidc_requires_issuer CHECK (((provider_type <> 'oidc'::text) OR (issuer IS NOT NULL))),
    CONSTRAINT custom_oauth_providers_provider_type_check CHECK ((provider_type = ANY (ARRAY['oauth2'::text, 'oidc'::text]))),
    CONSTRAINT custom_oauth_providers_token_url_https CHECK (((token_url IS NULL) OR (token_url ~~ 'https://%'::text))),
    CONSTRAINT custom_oauth_providers_token_url_length CHECK (((token_url IS NULL) OR (char_length(token_url) <= 2048))),
    CONSTRAINT custom_oauth_providers_userinfo_url_https CHECK (((userinfo_url IS NULL) OR (userinfo_url ~~ 'https://%'::text))),
    CONSTRAINT custom_oauth_providers_userinfo_url_length CHECK (((userinfo_url IS NULL) OR (char_length(userinfo_url) <= 2048)))
);


ALTER TABLE auth.custom_oauth_providers OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 33931)
-- Name: flow_state; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.flow_state (
    id uuid NOT NULL,
    user_id uuid,
    auth_code text,
    code_challenge_method auth.code_challenge_method,
    code_challenge text,
    provider_type text NOT NULL,
    provider_access_token text,
    provider_refresh_token text,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    authentication_method text NOT NULL,
    auth_code_issued_at timestamp with time zone,
    invite_token text,
    referrer text,
    oauth_client_state_id uuid,
    linking_target_id uuid,
    email_optional boolean DEFAULT false NOT NULL
);


ALTER TABLE auth.flow_state OWNER TO postgres;

--
-- TOC entry 5915 (class 0 OID 0)
-- Dependencies: 237
-- Name: TABLE flow_state; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.flow_state IS 'Stores metadata for all OAuth/SSO login flows';


--
-- TOC entry 238 (class 1259 OID 33941)
-- Name: identities; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.identities (
    provider_id text NOT NULL,
    user_id uuid NOT NULL,
    identity_data jsonb NOT NULL,
    provider text NOT NULL,
    last_sign_in_at timestamp with time zone,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    email text GENERATED ALWAYS AS (lower((identity_data ->> 'email'::text))) STORED,
    id uuid DEFAULT gen_random_uuid() NOT NULL
);


ALTER TABLE auth.identities OWNER TO postgres;

--
-- TOC entry 5916 (class 0 OID 0)
-- Dependencies: 238
-- Name: TABLE identities; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.identities IS 'Auth: Stores identities associated to a user.';


--
-- TOC entry 5917 (class 0 OID 0)
-- Dependencies: 238
-- Name: COLUMN identities.email; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.identities.email IS 'Auth: Email is a generated column that references the optional email property in the identity_data';


--
-- TOC entry 239 (class 1259 OID 33953)
-- Name: instances; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.instances (
    id uuid NOT NULL,
    uuid uuid,
    raw_base_config text,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);


ALTER TABLE auth.instances OWNER TO postgres;

--
-- TOC entry 5918 (class 0 OID 0)
-- Dependencies: 239
-- Name: TABLE instances; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.instances IS 'Auth: Manages users across multiple sites.';


--
-- TOC entry 240 (class 1259 OID 33959)
-- Name: mfa_amr_claims; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.mfa_amr_claims (
    session_id uuid NOT NULL,
    created_at timestamp with time zone NOT NULL,
    updated_at timestamp with time zone NOT NULL,
    authentication_method text NOT NULL,
    id uuid NOT NULL
);


ALTER TABLE auth.mfa_amr_claims OWNER TO postgres;

--
-- TOC entry 5919 (class 0 OID 0)
-- Dependencies: 240
-- Name: TABLE mfa_amr_claims; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.mfa_amr_claims IS 'auth: stores authenticator method reference claims for multi factor authentication';


--
-- TOC entry 241 (class 1259 OID 33969)
-- Name: mfa_challenges; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.mfa_challenges (
    id uuid NOT NULL,
    factor_id uuid NOT NULL,
    created_at timestamp with time zone NOT NULL,
    verified_at timestamp with time zone,
    ip_address inet NOT NULL,
    otp_code text,
    web_authn_session_data jsonb
);


ALTER TABLE auth.mfa_challenges OWNER TO postgres;

--
-- TOC entry 5920 (class 0 OID 0)
-- Dependencies: 241
-- Name: TABLE mfa_challenges; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.mfa_challenges IS 'auth: stores metadata about challenge requests made';


--
-- TOC entry 242 (class 1259 OID 33978)
-- Name: mfa_factors; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.mfa_factors (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    friendly_name text,
    factor_type auth.factor_type NOT NULL,
    status auth.factor_status NOT NULL,
    created_at timestamp with time zone NOT NULL,
    updated_at timestamp with time zone NOT NULL,
    secret text,
    phone text,
    last_challenged_at timestamp with time zone,
    web_authn_credential jsonb,
    web_authn_aaguid uuid,
    last_webauthn_challenge_data jsonb
);


ALTER TABLE auth.mfa_factors OWNER TO postgres;

--
-- TOC entry 5921 (class 0 OID 0)
-- Dependencies: 242
-- Name: TABLE mfa_factors; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.mfa_factors IS 'auth: stores metadata about factors';


--
-- TOC entry 5922 (class 0 OID 0)
-- Dependencies: 242
-- Name: COLUMN mfa_factors.last_webauthn_challenge_data; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.mfa_factors.last_webauthn_challenge_data IS 'Stores the latest WebAuthn challenge data including attestation/assertion for customer verification';


--
-- TOC entry 243 (class 1259 OID 33989)
-- Name: oauth_authorizations; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.oauth_authorizations (
    id uuid NOT NULL,
    authorization_id text NOT NULL,
    client_id uuid NOT NULL,
    user_id uuid,
    redirect_uri text NOT NULL,
    scope text NOT NULL,
    state text,
    resource text,
    code_challenge text,
    code_challenge_method auth.code_challenge_method,
    response_type auth.oauth_response_type DEFAULT 'code'::auth.oauth_response_type NOT NULL,
    status auth.oauth_authorization_status DEFAULT 'pending'::auth.oauth_authorization_status NOT NULL,
    authorization_code text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    expires_at timestamp with time zone DEFAULT (now() + '00:03:00'::interval) NOT NULL,
    approved_at timestamp with time zone,
    nonce text,
    CONSTRAINT oauth_authorizations_authorization_code_length CHECK ((char_length(authorization_code) <= 255)),
    CONSTRAINT oauth_authorizations_code_challenge_length CHECK ((char_length(code_challenge) <= 128)),
    CONSTRAINT oauth_authorizations_expires_at_future CHECK ((expires_at > created_at)),
    CONSTRAINT oauth_authorizations_nonce_length CHECK ((char_length(nonce) <= 255)),
    CONSTRAINT oauth_authorizations_redirect_uri_length CHECK ((char_length(redirect_uri) <= 2048)),
    CONSTRAINT oauth_authorizations_resource_length CHECK ((char_length(resource) <= 2048)),
    CONSTRAINT oauth_authorizations_scope_length CHECK ((char_length(scope) <= 4096)),
    CONSTRAINT oauth_authorizations_state_length CHECK ((char_length(state) <= 4096))
);


ALTER TABLE auth.oauth_authorizations OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 34015)
-- Name: oauth_client_states; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.oauth_client_states (
    id uuid NOT NULL,
    provider_type text NOT NULL,
    code_verifier text,
    created_at timestamp with time zone NOT NULL
);


ALTER TABLE auth.oauth_client_states OWNER TO postgres;

--
-- TOC entry 5923 (class 0 OID 0)
-- Dependencies: 244
-- Name: TABLE oauth_client_states; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.oauth_client_states IS 'Stores OAuth states for third-party provider authentication flows where Supabase acts as the OAuth client.';


--
-- TOC entry 245 (class 1259 OID 34023)
-- Name: oauth_clients; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.oauth_clients (
    id uuid NOT NULL,
    client_secret_hash text,
    registration_type auth.oauth_registration_type NOT NULL,
    redirect_uris text NOT NULL,
    grant_types text NOT NULL,
    client_name text,
    client_uri text,
    logo_uri text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    deleted_at timestamp with time zone,
    client_type auth.oauth_client_type DEFAULT 'confidential'::auth.oauth_client_type NOT NULL,
    token_endpoint_auth_method text NOT NULL,
    CONSTRAINT oauth_clients_client_name_length CHECK ((char_length(client_name) <= 1024)),
    CONSTRAINT oauth_clients_client_uri_length CHECK ((char_length(client_uri) <= 2048)),
    CONSTRAINT oauth_clients_logo_uri_length CHECK ((char_length(logo_uri) <= 2048)),
    CONSTRAINT oauth_clients_token_endpoint_auth_method_check CHECK ((token_endpoint_auth_method = ANY (ARRAY['client_secret_basic'::text, 'client_secret_post'::text, 'none'::text])))
);


ALTER TABLE auth.oauth_clients OWNER TO postgres;

--
-- TOC entry 246 (class 1259 OID 34043)
-- Name: oauth_consents; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.oauth_consents (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    client_id uuid NOT NULL,
    scopes text NOT NULL,
    granted_at timestamp with time zone DEFAULT now() NOT NULL,
    revoked_at timestamp with time zone,
    CONSTRAINT oauth_consents_revoked_after_granted CHECK (((revoked_at IS NULL) OR (revoked_at >= granted_at))),
    CONSTRAINT oauth_consents_scopes_length CHECK ((char_length(scopes) <= 2048)),
    CONSTRAINT oauth_consents_scopes_not_empty CHECK ((char_length(TRIM(BOTH FROM scopes)) > 0))
);


ALTER TABLE auth.oauth_consents OWNER TO postgres;

--
-- TOC entry 247 (class 1259 OID 34057)
-- Name: one_time_tokens; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.one_time_tokens (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    token_type auth.one_time_token_type NOT NULL,
    token_hash text NOT NULL,
    relates_to text NOT NULL,
    created_at timestamp without time zone DEFAULT now() NOT NULL,
    updated_at timestamp without time zone DEFAULT now() NOT NULL,
    CONSTRAINT one_time_tokens_token_hash_check CHECK ((char_length(token_hash) > 0))
);


ALTER TABLE auth.one_time_tokens OWNER TO postgres;

--
-- TOC entry 248 (class 1259 OID 34072)
-- Name: refresh_tokens; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.refresh_tokens (
    instance_id uuid,
    id bigint NOT NULL,
    token character varying(255),
    user_id character varying(255),
    revoked boolean,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    parent character varying(255),
    session_id uuid
);


ALTER TABLE auth.refresh_tokens OWNER TO postgres;

--
-- TOC entry 5924 (class 0 OID 0)
-- Dependencies: 248
-- Name: TABLE refresh_tokens; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.refresh_tokens IS 'Auth: Store of tokens used to refresh JWT tokens once they expire.';


--
-- TOC entry 249 (class 1259 OID 34078)
-- Name: refresh_tokens_id_seq; Type: SEQUENCE; Schema: auth; Owner: postgres
--

CREATE SEQUENCE auth.refresh_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE auth.refresh_tokens_id_seq OWNER TO postgres;

--
-- TOC entry 5925 (class 0 OID 0)
-- Dependencies: 249
-- Name: refresh_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: postgres
--

ALTER SEQUENCE auth.refresh_tokens_id_seq OWNED BY auth.refresh_tokens.id;


--
-- TOC entry 250 (class 1259 OID 34079)
-- Name: saml_providers; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.saml_providers (
    id uuid NOT NULL,
    sso_provider_id uuid NOT NULL,
    entity_id text NOT NULL,
    metadata_xml text NOT NULL,
    metadata_url text,
    attribute_mapping jsonb,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    name_id_format text,
    CONSTRAINT "entity_id not empty" CHECK ((char_length(entity_id) > 0)),
    CONSTRAINT "metadata_url not empty" CHECK (((metadata_url = NULL::text) OR (char_length(metadata_url) > 0))),
    CONSTRAINT "metadata_xml not empty" CHECK ((char_length(metadata_xml) > 0))
);


ALTER TABLE auth.saml_providers OWNER TO postgres;

--
-- TOC entry 5926 (class 0 OID 0)
-- Dependencies: 250
-- Name: TABLE saml_providers; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.saml_providers IS 'Auth: Manages SAML Identity Provider connections.';


--
-- TOC entry 251 (class 1259 OID 34091)
-- Name: saml_relay_states; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.saml_relay_states (
    id uuid NOT NULL,
    sso_provider_id uuid NOT NULL,
    request_id text NOT NULL,
    for_email text,
    redirect_to text,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    flow_state_id uuid,
    CONSTRAINT "request_id not empty" CHECK ((char_length(request_id) > 0))
);


ALTER TABLE auth.saml_relay_states OWNER TO postgres;

--
-- TOC entry 5927 (class 0 OID 0)
-- Dependencies: 251
-- Name: TABLE saml_relay_states; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.saml_relay_states IS 'Auth: Contains SAML Relay State information for each Service Provider initiated login.';


--
-- TOC entry 252 (class 1259 OID 34100)
-- Name: schema_migrations; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.schema_migrations (
    version character varying(255) NOT NULL
);


ALTER TABLE auth.schema_migrations OWNER TO postgres;

--
-- TOC entry 5928 (class 0 OID 0)
-- Dependencies: 252
-- Name: TABLE schema_migrations; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.schema_migrations IS 'Auth: Manages updates to the auth system.';


--
-- TOC entry 253 (class 1259 OID 34104)
-- Name: sessions; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.sessions (
    id uuid NOT NULL,
    user_id uuid NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    factor_id uuid,
    aal auth.aal_level,
    not_after timestamp with time zone,
    refreshed_at timestamp without time zone,
    user_agent text,
    ip inet,
    tag text,
    oauth_client_id uuid,
    refresh_token_hmac_key text,
    refresh_token_counter bigint,
    scopes text,
    CONSTRAINT sessions_scopes_length CHECK ((char_length(scopes) <= 4096))
);


ALTER TABLE auth.sessions OWNER TO postgres;

--
-- TOC entry 5930 (class 0 OID 0)
-- Dependencies: 253
-- Name: TABLE sessions; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.sessions IS 'Auth: Stores session data associated to a user.';


--
-- TOC entry 5931 (class 0 OID 0)
-- Dependencies: 253
-- Name: COLUMN sessions.not_after; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.sessions.not_after IS 'Auth: Not after is a nullable column that contains a timestamp after which the session should be regarded as expired.';


--
-- TOC entry 5932 (class 0 OID 0)
-- Dependencies: 253
-- Name: COLUMN sessions.refresh_token_hmac_key; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.sessions.refresh_token_hmac_key IS 'Holds a HMAC-SHA256 key used to sign refresh tokens for this session.';


--
-- TOC entry 5933 (class 0 OID 0)
-- Dependencies: 253
-- Name: COLUMN sessions.refresh_token_counter; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.sessions.refresh_token_counter IS 'Holds the ID (counter) of the last issued refresh token.';


--
-- TOC entry 254 (class 1259 OID 34112)
-- Name: sso_domains; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.sso_domains (
    id uuid NOT NULL,
    sso_provider_id uuid NOT NULL,
    domain text NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    CONSTRAINT "domain not empty" CHECK ((char_length(domain) > 0))
);


ALTER TABLE auth.sso_domains OWNER TO postgres;

--
-- TOC entry 5934 (class 0 OID 0)
-- Dependencies: 254
-- Name: TABLE sso_domains; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.sso_domains IS 'Auth: Manages SSO email address domain mapping to an SSO Identity Provider.';


--
-- TOC entry 255 (class 1259 OID 34121)
-- Name: sso_providers; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.sso_providers (
    id uuid NOT NULL,
    resource_id text,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    disabled boolean,
    CONSTRAINT "resource_id not empty" CHECK (((resource_id = NULL::text) OR (char_length(resource_id) > 0)))
);


ALTER TABLE auth.sso_providers OWNER TO postgres;

--
-- TOC entry 5935 (class 0 OID 0)
-- Dependencies: 255
-- Name: TABLE sso_providers; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.sso_providers IS 'Auth: Manages SSO identity provider information; see saml_providers for SAML.';


--
-- TOC entry 5936 (class 0 OID 0)
-- Dependencies: 255
-- Name: COLUMN sso_providers.resource_id; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.sso_providers.resource_id IS 'Auth: Uniquely identifies a SSO provider according to a user-chosen resource ID (case insensitive), useful in infrastructure as code.';


--
-- TOC entry 256 (class 1259 OID 34128)
-- Name: users; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.users (
    instance_id uuid,
    id uuid NOT NULL,
    aud character varying(255),
    role character varying(255),
    email character varying(255),
    encrypted_password character varying(255),
    email_confirmed_at timestamp with time zone,
    invited_at timestamp with time zone,
    confirmation_token character varying(255),
    confirmation_sent_at timestamp with time zone,
    recovery_token character varying(255),
    recovery_sent_at timestamp with time zone,
    email_change_token_new character varying(255),
    email_change character varying(255),
    email_change_sent_at timestamp with time zone,
    last_sign_in_at timestamp with time zone,
    raw_app_meta_data jsonb,
    raw_user_meta_data jsonb,
    is_super_admin boolean,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    phone text DEFAULT NULL::character varying,
    phone_confirmed_at timestamp with time zone,
    phone_change text DEFAULT ''::character varying,
    phone_change_token character varying(255) DEFAULT ''::character varying,
    phone_change_sent_at timestamp with time zone,
    confirmed_at timestamp with time zone GENERATED ALWAYS AS (LEAST(email_confirmed_at, phone_confirmed_at)) STORED,
    email_change_token_current character varying(255) DEFAULT ''::character varying,
    email_change_confirm_status smallint DEFAULT 0,
    banned_until timestamp with time zone,
    reauthentication_token character varying(255) DEFAULT ''::character varying,
    reauthentication_sent_at timestamp with time zone,
    is_sso_user boolean DEFAULT false NOT NULL,
    deleted_at timestamp with time zone,
    is_anonymous boolean DEFAULT false NOT NULL,
    CONSTRAINT users_email_change_confirm_status_check CHECK (((email_change_confirm_status >= 0) AND (email_change_confirm_status <= 2)))
);


ALTER TABLE auth.users OWNER TO postgres;

--
-- TOC entry 5937 (class 0 OID 0)
-- Dependencies: 256
-- Name: TABLE users; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON TABLE auth.users IS 'Auth: Stores user login data within a secure schema.';


--
-- TOC entry 5938 (class 0 OID 0)
-- Dependencies: 256
-- Name: COLUMN users.is_sso_user; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON COLUMN auth.users.is_sso_user IS 'Auth: Set this column to true when the account comes from SSO. These accounts can have duplicate emails.';


--
-- TOC entry 257 (class 1259 OID 34146)
-- Name: webauthn_challenges; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.webauthn_challenges (
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    user_id uuid,
    challenge_type text NOT NULL,
    session_data jsonb NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    expires_at timestamp with time zone NOT NULL,
    CONSTRAINT webauthn_challenges_challenge_type_check CHECK ((challenge_type = ANY (ARRAY['signup'::text, 'registration'::text, 'authentication'::text])))
);


ALTER TABLE auth.webauthn_challenges OWNER TO postgres;

--
-- TOC entry 258 (class 1259 OID 34159)
-- Name: webauthn_credentials; Type: TABLE; Schema: auth; Owner: postgres
--

CREATE TABLE auth.webauthn_credentials (
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    user_id uuid NOT NULL,
    credential_id bytea NOT NULL,
    public_key bytea NOT NULL,
    attestation_type text DEFAULT ''::text NOT NULL,
    aaguid uuid,
    sign_count bigint DEFAULT 0 NOT NULL,
    transports jsonb DEFAULT '[]'::jsonb NOT NULL,
    backup_eligible boolean DEFAULT false NOT NULL,
    backed_up boolean DEFAULT false NOT NULL,
    friendly_name text DEFAULT ''::text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    last_used_at timestamp with time zone
);


ALTER TABLE auth.webauthn_credentials OWNER TO postgres;

--
-- TOC entry 259 (class 1259 OID 34185)
-- Name: Bans; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."Bans" (
    id bigint NOT NULL,
    id_users integer NOT NULL,
    end_time timestamp without time zone,
    reason character varying
);


ALTER TABLE public."Bans" OWNER TO postgres;

--
-- TOC entry 260 (class 1259 OID 34192)
-- Name: Bans_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public."Bans" ALTER COLUMN id ADD GENERATED BY DEFAULT AS IDENTITY (
    SEQUENCE NAME public."Bans_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 261 (class 1259 OID 34193)
-- Name: addresses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.addresses (
    id integer NOT NULL,
    user_id integer,
    street character varying(255),
    postal_code character varying(20),
    city character varying(100),
    is_default boolean DEFAULT false
);


ALTER TABLE public.addresses OWNER TO postgres;

--
-- TOC entry 262 (class 1259 OID 34198)
-- Name: addresses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.addresses_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.addresses_id_seq OWNER TO postgres;

--
-- TOC entry 5939 (class 0 OID 0)
-- Dependencies: 262
-- Name: addresses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.addresses_id_seq OWNED BY public.addresses.id;


--
-- TOC entry 263 (class 1259 OID 34199)
-- Name: attribute_cathegory; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attribute_cathegory (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.attribute_cathegory OWNER TO postgres;

--
-- TOC entry 264 (class 1259 OID 34204)
-- Name: attribute_values; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attribute_values (
    id integer NOT NULL,
    attribute_cathegory_id integer NOT NULL,
    value character varying(100) NOT NULL
);


ALTER TABLE public.attribute_values OWNER TO postgres;

--
-- TOC entry 265 (class 1259 OID 34210)
-- Name: attribute_values_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attribute_values_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.attribute_values_id_seq OWNER TO postgres;

--
-- TOC entry 5940 (class 0 OID 0)
-- Dependencies: 265
-- Name: attribute_values_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attribute_values_id_seq OWNED BY public.attribute_values.id;


--
-- TOC entry 266 (class 1259 OID 34211)
-- Name: attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.attributes_id_seq OWNER TO postgres;

--
-- TOC entry 5941 (class 0 OID 0)
-- Dependencies: 266
-- Name: attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attributes_id_seq OWNED BY public.attribute_cathegory.id;


--
-- TOC entry 267 (class 1259 OID 34212)
-- Name: brands; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.brands (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.brands OWNER TO postgres;

--
-- TOC entry 268 (class 1259 OID 34217)
-- Name: brands_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.brands_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.brands_id_seq OWNER TO postgres;

--
-- TOC entry 5942 (class 0 OID 0)
-- Dependencies: 268
-- Name: brands_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.brands_id_seq OWNED BY public.brands.id;


--
-- TOC entry 269 (class 1259 OID 34218)
-- Name: cart_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cart_items (
    id integer NOT NULL,
    user_id integer,
    product_id integer,
    quantity integer DEFAULT 1
);


ALTER TABLE public.cart_items OWNER TO postgres;

--
-- TOC entry 270 (class 1259 OID 34223)
-- Name: cart_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cart_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cart_items_id_seq OWNER TO postgres;

--
-- TOC entry 5943 (class 0 OID 0)
-- Dependencies: 270
-- Name: cart_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cart_items_id_seq OWNED BY public.cart_items.id;


--
-- TOC entry 271 (class 1259 OID 34224)
-- Name: categories; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    parrent_id integer
);


ALTER TABLE public.categories OWNER TO postgres;

--
-- TOC entry 272 (class 1259 OID 34229)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO postgres;

--
-- TOC entry 5944 (class 0 OID 0)
-- Dependencies: 272
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 273 (class 1259 OID 34230)
-- Name: category_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.category_attributes (
    id integer NOT NULL,
    category_id integer NOT NULL,
    attribute_id integer NOT NULL,
    is_required boolean DEFAULT false
);


ALTER TABLE public.category_attributes OWNER TO postgres;

--
-- TOC entry 274 (class 1259 OID 34237)
-- Name: category_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.category_attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.category_attributes_id_seq OWNER TO postgres;

--
-- TOC entry 5945 (class 0 OID 0)
-- Dependencies: 274
-- Name: category_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.category_attributes_id_seq OWNED BY public.category_attributes.id;


--
-- TOC entry 275 (class 1259 OID 34238)
-- Name: complaints; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.complaints (
    id integer NOT NULL,
    order_id integer,
    reason character varying(255),
    description text,
    status character varying(50) DEFAULT 'new'::character varying
);


ALTER TABLE public.complaints OWNER TO postgres;

--
-- TOC entry 276 (class 1259 OID 34245)
-- Name: complaints_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.complaints_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.complaints_id_seq OWNER TO postgres;

--
-- TOC entry 5946 (class 0 OID 0)
-- Dependencies: 276
-- Name: complaints_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.complaints_id_seq OWNED BY public.complaints.id;


--
-- TOC entry 277 (class 1259 OID 34246)
-- Name: order_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.order_items (
    id integer NOT NULL,
    order_id integer,
    product_id integer,
    quantity integer NOT NULL,
    unit_price numeric(10,2) NOT NULL
);


ALTER TABLE public.order_items OWNER TO postgres;

--
-- TOC entry 278 (class 1259 OID 34252)
-- Name: order_items_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.order_items_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.order_items_id_seq OWNER TO postgres;

--
-- TOC entry 5947 (class 0 OID 0)
-- Dependencies: 278
-- Name: order_items_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.order_items_id_seq OWNED BY public.order_items.id;


--
-- TOC entry 279 (class 1259 OID 34253)
-- Name: orders; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.orders (
    id integer NOT NULL,
    user_id integer,
    shipping_method_id integer,
    tracking_status character varying(100),
    shipping_cost numeric(10,2),
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    shipping_first_name character varying(255),
    shipping_street character varying(255),
    shipping_city character varying(255),
    shipping_postal_code character varying(20),
    shipping_phone character varying(255),
    shipping_last_name character varying
);


ALTER TABLE public.orders OWNER TO postgres;

--
-- TOC entry 280 (class 1259 OID 34260)
-- Name: orders_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.orders_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.orders_id_seq OWNER TO postgres;

--
-- TOC entry 5948 (class 0 OID 0)
-- Dependencies: 280
-- Name: orders_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.orders_id_seq OWNED BY public.orders.id;


--
-- TOC entry 281 (class 1259 OID 34261)
-- Name: product_attributes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_attributes (
    id integer NOT NULL,
    product_id integer NOT NULL,
    attribute_cathegory_id integer NOT NULL,
    attribute_value_id integer,
    value_text text,
    value_number numeric,
    value_boolean boolean
);


ALTER TABLE public.product_attributes OWNER TO postgres;

--
-- TOC entry 282 (class 1259 OID 34269)
-- Name: product_attributes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_attributes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.product_attributes_id_seq OWNER TO postgres;

--
-- TOC entry 5949 (class 0 OID 0)
-- Dependencies: 282
-- Name: product_attributes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_attributes_id_seq OWNED BY public.product_attributes.id;


--
-- TOC entry 283 (class 1259 OID 34270)
-- Name: products; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.products (
    id integer NOT NULL,
    category_id integer,
    brand_id integer,
    name character varying(255) NOT NULL,
    base_price numeric(10,2) NOT NULL,
    promo_price numeric(10,2),
    stock_quantity integer DEFAULT 0,
    power_draw_w integer DEFAULT 0,
    image_url text
);


ALTER TABLE public.products OWNER TO postgres;

--
-- TOC entry 284 (class 1259 OID 34280)
-- Name: products_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.products_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.products_id_seq OWNER TO postgres;

--
-- TOC entry 5950 (class 0 OID 0)
-- Dependencies: 284
-- Name: products_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.products_id_seq OWNED BY public.products.id;


--
-- TOC entry 285 (class 1259 OID 34281)
-- Name: reviews; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reviews (
    id integer NOT NULL,
    product_id integer,
    user_id integer,
    rating smallint,
    comment text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT reviews_rating_check CHECK (((rating >= 1) AND (rating <= 5)))
);


ALTER TABLE public.reviews OWNER TO postgres;

--
-- TOC entry 286 (class 1259 OID 34289)
-- Name: reviews_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reviews_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reviews_id_seq OWNER TO postgres;

--
-- TOC entry 5951 (class 0 OID 0)
-- Dependencies: 286
-- Name: reviews_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reviews_id_seq OWNED BY public.reviews.id;


--
-- TOC entry 287 (class 1259 OID 34290)
-- Name: shipping_methods; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.shipping_methods (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    price numeric(10,2) NOT NULL
);


ALTER TABLE public.shipping_methods OWNER TO postgres;

--
-- TOC entry 288 (class 1259 OID 34296)
-- Name: shipping_methods_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.shipping_methods_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.shipping_methods_id_seq OWNER TO postgres;

--
-- TOC entry 5952 (class 0 OID 0)
-- Dependencies: 288
-- Name: shipping_methods_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.shipping_methods_id_seq OWNED BY public.shipping_methods.id;


--
-- TOC entry 289 (class 1259 OID 34297)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password_hash character varying(255) NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    phone character varying(20),
    "is_Admin" boolean
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 290 (class 1259 OID 34305)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 5953 (class 0 OID 0)
-- Dependencies: 290
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 291 (class 1259 OID 34306)
-- Name: wishlist_items; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wishlist_items (
    wishlist_id integer NOT NULL,
    product_id integer NOT NULL
);


ALTER TABLE public.wishlist_items OWNER TO postgres;

--
-- TOC entry 292 (class 1259 OID 34311)
-- Name: wishlists; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.wishlists (
    id integer NOT NULL,
    user_id integer,
    name character varying(100)
);


ALTER TABLE public.wishlists OWNER TO postgres;

--
-- TOC entry 293 (class 1259 OID 34315)
-- Name: wishlists_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.wishlists_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.wishlists_id_seq OWNER TO postgres;

--
-- TOC entry 5954 (class 0 OID 0)
-- Dependencies: 293
-- Name: wishlists_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.wishlists_id_seq OWNED BY public.wishlists.id;


--
-- TOC entry 294 (class 1259 OID 34316)
-- Name: messages; Type: TABLE; Schema: realtime; Owner: postgres
--

CREATE TABLE realtime.messages (
    topic text NOT NULL,
    extension text NOT NULL,
    payload jsonb,
    event text,
    private boolean DEFAULT false,
    updated_at timestamp without time zone DEFAULT now() NOT NULL,
    inserted_at timestamp without time zone DEFAULT now() NOT NULL,
    id uuid DEFAULT gen_random_uuid() NOT NULL
)
PARTITION BY RANGE (inserted_at);


ALTER TABLE realtime.messages OWNER TO postgres;

--
-- TOC entry 295 (class 1259 OID 34328)
-- Name: schema_migrations; Type: TABLE; Schema: realtime; Owner: postgres
--

CREATE TABLE realtime.schema_migrations (
    version bigint NOT NULL,
    inserted_at timestamp(0) without time zone
);


ALTER TABLE realtime.schema_migrations OWNER TO postgres;

--
-- TOC entry 296 (class 1259 OID 34332)
-- Name: subscription; Type: TABLE; Schema: realtime; Owner: postgres
--

CREATE TABLE realtime.subscription (
    id bigint NOT NULL,
    subscription_id uuid NOT NULL,
    entity regclass NOT NULL,
    filters realtime.user_defined_filter[] DEFAULT '{}'::realtime.user_defined_filter[] NOT NULL,
    claims jsonb NOT NULL,
    claims_role regrole GENERATED ALWAYS AS (realtime.to_regrole((claims ->> 'role'::text))) STORED NOT NULL,
    created_at timestamp without time zone DEFAULT timezone('utc'::text, now()) NOT NULL,
    action_filter text DEFAULT '*'::text,
    CONSTRAINT subscription_action_filter_check CHECK ((action_filter = ANY (ARRAY['*'::text, 'INSERT'::text, 'UPDATE'::text, 'DELETE'::text])))
);


ALTER TABLE realtime.subscription OWNER TO postgres;

--
-- TOC entry 297 (class 1259 OID 34349)
-- Name: subscription_id_seq; Type: SEQUENCE; Schema: realtime; Owner: postgres
--

ALTER TABLE realtime.subscription ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME realtime.subscription_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 298 (class 1259 OID 34350)
-- Name: buckets; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.buckets (
    id text NOT NULL,
    name text NOT NULL,
    owner uuid,
    created_at timestamp with time zone DEFAULT now(),
    updated_at timestamp with time zone DEFAULT now(),
    public boolean DEFAULT false,
    avif_autodetection boolean DEFAULT false,
    file_size_limit bigint,
    allowed_mime_types text[],
    owner_id text,
    type storage.buckettype DEFAULT 'STANDARD'::storage.buckettype NOT NULL
);


ALTER TABLE storage.buckets OWNER TO postgres;

--
-- TOC entry 5955 (class 0 OID 0)
-- Dependencies: 298
-- Name: COLUMN buckets.owner; Type: COMMENT; Schema: storage; Owner: postgres
--

COMMENT ON COLUMN storage.buckets.owner IS 'Field is deprecated, use owner_id instead';


--
-- TOC entry 299 (class 1259 OID 34363)
-- Name: buckets_analytics; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.buckets_analytics (
    name text NOT NULL,
    type storage.buckettype DEFAULT 'ANALYTICS'::storage.buckettype NOT NULL,
    format text DEFAULT 'ICEBERG'::text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL,
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    deleted_at timestamp with time zone
);


ALTER TABLE storage.buckets_analytics OWNER TO postgres;

--
-- TOC entry 300 (class 1259 OID 34379)
-- Name: buckets_vectors; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.buckets_vectors (
    id text NOT NULL,
    type storage.buckettype DEFAULT 'VECTOR'::storage.buckettype NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE storage.buckets_vectors OWNER TO postgres;

--
-- TOC entry 301 (class 1259 OID 34391)
-- Name: migrations; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.migrations (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    hash character varying(40) NOT NULL,
    executed_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE storage.migrations OWNER TO postgres;

--
-- TOC entry 302 (class 1259 OID 34398)
-- Name: objects; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.objects (
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    bucket_id text,
    name text,
    owner uuid,
    created_at timestamp with time zone DEFAULT now(),
    updated_at timestamp with time zone DEFAULT now(),
    last_accessed_at timestamp with time zone DEFAULT now(),
    metadata jsonb,
    path_tokens text[] GENERATED ALWAYS AS (string_to_array(name, '/'::text)) STORED,
    version text,
    owner_id text,
    user_metadata jsonb
);


ALTER TABLE storage.objects OWNER TO postgres;

--
-- TOC entry 5956 (class 0 OID 0)
-- Dependencies: 302
-- Name: COLUMN objects.owner; Type: COMMENT; Schema: storage; Owner: postgres
--

COMMENT ON COLUMN storage.objects.owner IS 'Field is deprecated, use owner_id instead';


--
-- TOC entry 303 (class 1259 OID 34409)
-- Name: s3_multipart_uploads; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.s3_multipart_uploads (
    id text NOT NULL,
    in_progress_size bigint DEFAULT 0 NOT NULL,
    upload_signature text NOT NULL,
    bucket_id text NOT NULL,
    key text NOT NULL COLLATE pg_catalog."C",
    version text NOT NULL,
    owner_id text,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    user_metadata jsonb,
    metadata jsonb
);


ALTER TABLE storage.s3_multipart_uploads OWNER TO postgres;

--
-- TOC entry 304 (class 1259 OID 34423)
-- Name: s3_multipart_uploads_parts; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.s3_multipart_uploads_parts (
    id uuid DEFAULT gen_random_uuid() NOT NULL,
    upload_id text NOT NULL,
    size bigint DEFAULT 0 NOT NULL,
    part_number integer NOT NULL,
    bucket_id text NOT NULL,
    key text NOT NULL COLLATE pg_catalog."C",
    etag text NOT NULL,
    owner_id text,
    version text NOT NULL,
    created_at timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE storage.s3_multipart_uploads_parts OWNER TO postgres;

--
-- TOC entry 305 (class 1259 OID 34440)
-- Name: vector_indexes; Type: TABLE; Schema: storage; Owner: postgres
--

CREATE TABLE storage.vector_indexes (
    id text DEFAULT gen_random_uuid() NOT NULL,
    name text NOT NULL COLLATE pg_catalog."C",
    bucket_id text NOT NULL,
    data_type text NOT NULL,
    dimension integer NOT NULL,
    distance_metric text NOT NULL,
    metadata_configuration jsonb,
    created_at timestamp with time zone DEFAULT now() NOT NULL,
    updated_at timestamp with time zone DEFAULT now() NOT NULL
);


ALTER TABLE storage.vector_indexes OWNER TO postgres;

--
-- TOC entry 5266 (class 2604 OID 34456)
-- Name: refresh_tokens id; Type: DEFAULT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.refresh_tokens ALTER COLUMN id SET DEFAULT nextval('auth.refresh_tokens_id_seq'::regclass);


--
-- TOC entry 5287 (class 2604 OID 34457)
-- Name: addresses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.addresses ALTER COLUMN id SET DEFAULT nextval('public.addresses_id_seq'::regclass);


--
-- TOC entry 5289 (class 2604 OID 34458)
-- Name: attribute_cathegory id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_cathegory ALTER COLUMN id SET DEFAULT nextval('public.attributes_id_seq'::regclass);


--
-- TOC entry 5290 (class 2604 OID 34459)
-- Name: attribute_values id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values ALTER COLUMN id SET DEFAULT nextval('public.attribute_values_id_seq'::regclass);


--
-- TOC entry 5291 (class 2604 OID 34460)
-- Name: brands id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.brands ALTER COLUMN id SET DEFAULT nextval('public.brands_id_seq'::regclass);


--
-- TOC entry 5292 (class 2604 OID 34461)
-- Name: cart_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items ALTER COLUMN id SET DEFAULT nextval('public.cart_items_id_seq'::regclass);


--
-- TOC entry 5294 (class 2604 OID 34462)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 5295 (class 2604 OID 34463)
-- Name: category_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_attributes ALTER COLUMN id SET DEFAULT nextval('public.category_attributes_id_seq'::regclass);


--
-- TOC entry 5297 (class 2604 OID 34464)
-- Name: complaints id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.complaints ALTER COLUMN id SET DEFAULT nextval('public.complaints_id_seq'::regclass);


--
-- TOC entry 5299 (class 2604 OID 34465)
-- Name: order_items id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items ALTER COLUMN id SET DEFAULT nextval('public.order_items_id_seq'::regclass);


--
-- TOC entry 5300 (class 2604 OID 34466)
-- Name: orders id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders ALTER COLUMN id SET DEFAULT nextval('public.orders_id_seq'::regclass);


--
-- TOC entry 5302 (class 2604 OID 34467)
-- Name: product_attributes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_attributes ALTER COLUMN id SET DEFAULT nextval('public.product_attributes_id_seq'::regclass);


--
-- TOC entry 5303 (class 2604 OID 34468)
-- Name: products id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products ALTER COLUMN id SET DEFAULT nextval('public.products_id_seq'::regclass);


--
-- TOC entry 5306 (class 2604 OID 34469)
-- Name: reviews id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews ALTER COLUMN id SET DEFAULT nextval('public.reviews_id_seq'::regclass);


--
-- TOC entry 5308 (class 2604 OID 34470)
-- Name: shipping_methods id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shipping_methods ALTER COLUMN id SET DEFAULT nextval('public.shipping_methods_id_seq'::regclass);


--
-- TOC entry 5309 (class 2604 OID 34471)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 5310 (class 2604 OID 34472)
-- Name: wishlists id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists ALTER COLUMN id SET DEFAULT nextval('public.wishlists_id_seq'::regclass);


--
-- TOC entry 5824 (class 0 OID 33873)
-- Dependencies: 235
-- Data for Name: audit_log_entries; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.audit_log_entries (instance_id, id, payload, created_at, ip_address) FROM stdin;
\.


--
-- TOC entry 5825 (class 0 OID 33881)
-- Dependencies: 236
-- Data for Name: custom_oauth_providers; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.custom_oauth_providers (id, provider_type, identifier, name, client_id, client_secret, acceptable_client_ids, scopes, pkce_enabled, attribute_mapping, authorization_params, enabled, email_optional, issuer, discovery_url, skip_nonce_check, cached_discovery, discovery_cached_at, authorization_url, token_url, userinfo_url, jwks_uri, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5826 (class 0 OID 33931)
-- Dependencies: 237
-- Data for Name: flow_state; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.flow_state (id, user_id, auth_code, code_challenge_method, code_challenge, provider_type, provider_access_token, provider_refresh_token, created_at, updated_at, authentication_method, auth_code_issued_at, invite_token, referrer, oauth_client_state_id, linking_target_id, email_optional) FROM stdin;
\.


--
-- TOC entry 5827 (class 0 OID 33941)
-- Dependencies: 238
-- Data for Name: identities; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.identities (provider_id, user_id, identity_data, provider, last_sign_in_at, created_at, updated_at, id) FROM stdin;
\.


--
-- TOC entry 5828 (class 0 OID 33953)
-- Dependencies: 239
-- Data for Name: instances; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.instances (id, uuid, raw_base_config, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5829 (class 0 OID 33959)
-- Dependencies: 240
-- Data for Name: mfa_amr_claims; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.mfa_amr_claims (session_id, created_at, updated_at, authentication_method, id) FROM stdin;
\.


--
-- TOC entry 5830 (class 0 OID 33969)
-- Dependencies: 241
-- Data for Name: mfa_challenges; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.mfa_challenges (id, factor_id, created_at, verified_at, ip_address, otp_code, web_authn_session_data) FROM stdin;
\.


--
-- TOC entry 5831 (class 0 OID 33978)
-- Dependencies: 242
-- Data for Name: mfa_factors; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.mfa_factors (id, user_id, friendly_name, factor_type, status, created_at, updated_at, secret, phone, last_challenged_at, web_authn_credential, web_authn_aaguid, last_webauthn_challenge_data) FROM stdin;
\.


--
-- TOC entry 5832 (class 0 OID 33989)
-- Dependencies: 243
-- Data for Name: oauth_authorizations; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.oauth_authorizations (id, authorization_id, client_id, user_id, redirect_uri, scope, state, resource, code_challenge, code_challenge_method, response_type, status, authorization_code, created_at, expires_at, approved_at, nonce) FROM stdin;
\.


--
-- TOC entry 5833 (class 0 OID 34015)
-- Dependencies: 244
-- Data for Name: oauth_client_states; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.oauth_client_states (id, provider_type, code_verifier, created_at) FROM stdin;
\.


--
-- TOC entry 5834 (class 0 OID 34023)
-- Dependencies: 245
-- Data for Name: oauth_clients; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.oauth_clients (id, client_secret_hash, registration_type, redirect_uris, grant_types, client_name, client_uri, logo_uri, created_at, updated_at, deleted_at, client_type, token_endpoint_auth_method) FROM stdin;
\.


--
-- TOC entry 5835 (class 0 OID 34043)
-- Dependencies: 246
-- Data for Name: oauth_consents; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.oauth_consents (id, user_id, client_id, scopes, granted_at, revoked_at) FROM stdin;
\.


--
-- TOC entry 5836 (class 0 OID 34057)
-- Dependencies: 247
-- Data for Name: one_time_tokens; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.one_time_tokens (id, user_id, token_type, token_hash, relates_to, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5837 (class 0 OID 34072)
-- Dependencies: 248
-- Data for Name: refresh_tokens; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.refresh_tokens (instance_id, id, token, user_id, revoked, created_at, updated_at, parent, session_id) FROM stdin;
\.


--
-- TOC entry 5839 (class 0 OID 34079)
-- Dependencies: 250
-- Data for Name: saml_providers; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.saml_providers (id, sso_provider_id, entity_id, metadata_xml, metadata_url, attribute_mapping, created_at, updated_at, name_id_format) FROM stdin;
\.


--
-- TOC entry 5840 (class 0 OID 34091)
-- Dependencies: 251
-- Data for Name: saml_relay_states; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.saml_relay_states (id, sso_provider_id, request_id, for_email, redirect_to, created_at, updated_at, flow_state_id) FROM stdin;
\.


--
-- TOC entry 5841 (class 0 OID 34100)
-- Dependencies: 252
-- Data for Name: schema_migrations; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.schema_migrations (version) FROM stdin;
20171026211738
20171026211808
20171026211834
20180103212743
20180108183307
20180119214651
20180125194653
00
20210710035447
20210722035447
20210730183235
20210909172000
20210927181326
20211122151130
20211124214934
20211202183645
20220114185221
20220114185340
20220224000811
20220323170000
20220429102000
20220531120530
20220614074223
20220811173540
20221003041349
20221003041400
20221011041400
20221020193600
20221021073300
20221021082433
20221027105023
20221114143122
20221114143410
20221125140132
20221208132122
20221215195500
20221215195800
20221215195900
20230116124310
20230116124412
20230131181311
20230322519590
20230402418590
20230411005111
20230508135423
20230523124323
20230818113222
20230914180801
20231027141322
20231114161723
20231117164230
20240115144230
20240214120130
20240306115329
20240314092811
20240427152123
20240612123726
20240729123726
20240802193726
20240806073726
20241009103726
20250717082212
20250731150234
20250804100000
20250901200500
20250903112500
20250904133000
20250925093508
20251007112900
20251104100000
20251111201300
20251201000000
20260115000000
20260121000000
20260219120000
20260302000000
\.


--
-- TOC entry 5842 (class 0 OID 34104)
-- Dependencies: 253
-- Data for Name: sessions; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.sessions (id, user_id, created_at, updated_at, factor_id, aal, not_after, refreshed_at, user_agent, ip, tag, oauth_client_id, refresh_token_hmac_key, refresh_token_counter, scopes) FROM stdin;
\.


--
-- TOC entry 5843 (class 0 OID 34112)
-- Dependencies: 254
-- Data for Name: sso_domains; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.sso_domains (id, sso_provider_id, domain, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5844 (class 0 OID 34121)
-- Dependencies: 255
-- Data for Name: sso_providers; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.sso_providers (id, resource_id, created_at, updated_at, disabled) FROM stdin;
\.


--
-- TOC entry 5845 (class 0 OID 34128)
-- Dependencies: 256
-- Data for Name: users; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.users (instance_id, id, aud, role, email, encrypted_password, email_confirmed_at, invited_at, confirmation_token, confirmation_sent_at, recovery_token, recovery_sent_at, email_change_token_new, email_change, email_change_sent_at, last_sign_in_at, raw_app_meta_data, raw_user_meta_data, is_super_admin, created_at, updated_at, phone, phone_confirmed_at, phone_change, phone_change_token, phone_change_sent_at, email_change_token_current, email_change_confirm_status, banned_until, reauthentication_token, reauthentication_sent_at, is_sso_user, deleted_at, is_anonymous) FROM stdin;
\.


--
-- TOC entry 5846 (class 0 OID 34146)
-- Dependencies: 257
-- Data for Name: webauthn_challenges; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.webauthn_challenges (id, user_id, challenge_type, session_data, created_at, expires_at) FROM stdin;
\.


--
-- TOC entry 5847 (class 0 OID 34159)
-- Dependencies: 258
-- Data for Name: webauthn_credentials; Type: TABLE DATA; Schema: auth; Owner: postgres
--

COPY auth.webauthn_credentials (id, user_id, credential_id, public_key, attestation_type, aaguid, sign_count, transports, backup_eligible, backed_up, friendly_name, created_at, updated_at, last_used_at) FROM stdin;
\.


--
-- TOC entry 5848 (class 0 OID 34185)
-- Dependencies: 259
-- Data for Name: Bans; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."Bans" (id, id_users, end_time, reason) FROM stdin;
\.


--
-- TOC entry 5850 (class 0 OID 34193)
-- Dependencies: 261
-- Data for Name: addresses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.addresses (id, user_id, street, postal_code, city, is_default) FROM stdin;
\.


--
-- TOC entry 5852 (class 0 OID 34199)
-- Dependencies: 263
-- Data for Name: attribute_cathegory; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attribute_cathegory (id, name) FROM stdin;
1	socket
3	cores
2	cpu_type
4	threads
5	base_clock
6	boost_clock
10	graphics_card_series
11	motherboard_chipset
12	board_standard
13	ram_type
14	ram_capacity_gb
15	ram_speed_mhz
16	ram_latency_cl
17	storage_type
18	storage_capacity_gb
19	storage_interface
20	psu_wattage
21	psu_efficiency_rating
22	psu_standard
23	case_type
24	max_gpu_length_mm
25	max_cpu_cooler_height_mm
26	connectivity_type
27	sensor_type
28	switch_type
29	audio_channels
30	cooler_type
31	tdp_rating
32	network_standard
33	interface_type
34	monitor_resolution
35	refresh_rate_hz
36	panel_type
37	screen_size_inch
7	integrated_gpu
8	connector_type
9	chipset_manufacturer
38	fan_included
39	fan_max_tdp
\.


--
-- TOC entry 5853 (class 0 OID 34204)
-- Dependencies: 264
-- Data for Name: attribute_values; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attribute_values (id, attribute_cathegory_id, value) FROM stdin;
1	1	AM4
2	1	AM5
19	10	RTX z serii 30
20	10	RTX z serii 40
21	10	RTX z serii 50
22	10	RX z serii 6
23	10	RX z serii 7
24	10	RX z serii 9
25	10	Intel Arc
55	9	NVIDIA
56	9	AMD
57	9	Intel
58	11	B860
59	11	B850
4	1	LGA 1700
3	1	LGA 1200
5	1	LGA 1851
10	2	AMD Ryzen 7
11	2	AMD Ryzen 9
12	2	Intel Core i3
13	2	Intel Core i5
14	2	Intel Core i7
15	2	Intel Core i9
16	2	Intel Core Ultra 5
17	2	Intel Core Ultra 7
18	2	Intel Core Ultra 9
8	2	AMD Ryzen 3
9	2	AMD Ryzen 5
7	1	sTR5
6	1	LGA 2066
26	11	B450
27	11	B550
28	11	X570
29	11	B650
30	11	X670
31	11	B760
32	11	Z790
33	12	ATX
34	12	m-ATX
35	12	Mini-ITX
36	12	E-ATX
37	13	DDR4
38	13	DDR5
39	17	HDD
40	17	SSD
41	17	M.2 NVMe
42	19	SATA III
43	19	PCIe 3.0 x4
44	19	PCIe 4.0 x4
45	19	PCIe 5.0 x4
46	21	80 Plus Bronze
47	21	80 Plus Silver
48	21	80 Plus Gold
49	21	80 Plus Platinum
50	21	80 Plus Titanium
51	22	ATX
52	22	SFX
53	22	TFX
60	24	305.0
61	6	5000.0
62	18	2000000.0
63	6	4700
64	20	550.0
65	39	260
66	4	32.0
67	6	5600.0
68	24	315.0
69	24	310.0
70	5	4300.0
71	37	31.5
72	6	4600
73	35	240.0
74	3	10.0
75	18	512.0
76	25	161.0
77	5	3300.0
78	15	6000.0
79	24	368.0
80	25	179.0
81	20	850.0
82	37	24.5
83	4	16
84	24	330.0
85	25	162.0
86	35	144.0
87	6	4200
88	25	159.0
89	16	36.0
90	5	4700.0
91	3	6
92	37	23.8
93	18	1000000.0
94	14	32.0
95	4	16.0
96	15	3200.0
97	5	3400
98	3	8
99	14	64.0
100	4	20.0
101	24	459.0
102	5	3800
103	6	5400.0
104	25	168.0
105	39	250
106	39	280
107	6	5300.0
108	20	750.0
109	5	3900.0
110	5	3800.0
111	16	32.0
112	24	370.0
113	15	6400.0
114	3	20
115	5	3200.0
116	25	190.0
117	24	450.0
118	5	3400.0
119	5	2500.0
120	25	166.0
121	25	185.0
122	6	5500.0
123	25	163.0
124	24	400.0
125	39	300
126	35	100.0
127	5	3500.0
128	5	3700.0
129	20	1600.0
130	16	20.0
131	6	5100.0
132	18	1024000.0
133	5	4000.0
134	5	4200.0
135	25	178.0
136	3	16.0
137	4	24.0
138	6	4400.0
139	15	3600.0
140	5	3500
141	4	12.0
142	25	165.0
143	24	425.0
144	5	3600
145	35	320.0
146	35	200.0
147	39	220
148	18	4096000.0
149	37	27.0
150	24	365.0
151	35	180.0
152	24	349.0
153	3	24.0
154	24	430.0
155	3	8.0
156	16	18.0
157	24	369.0
158	3	18.0
159	16	16.0
160	3	12.0
161	16	17.0
162	5	3600.0
163	4	18.0
164	39	150
165	4	10.0
166	6	5700.0
167	6	4500.0
168	24	410.0
169	6	4700.0
170	15	5600.0
171	39	200
172	25	180.0
173	14	32
174	25	175.0
175	3	6.0
176	24	415.0
177	4	14.0
178	4	12
179	39	180
180	24	380.0
181	20	600.0
182	39	320
183	5	3700
184	6	5200.0
185	6	4400
186	16	30.0
187	18	2048000.0
188	3	20.0
189	20	1200.0
190	37	34.0
191	3	14.0
192	24	320.0
193	14	16.0
194	6	4900.0
195	6	6000.0
196	20	650.0
197	37	26.5
198	16	46.0
199	25	170.0
200	39	240
201	20	1000.0
202	7	false
203	38	false
204	7	true
205	38	true
206	23	Full Tower
207	36	400 cd/m²
208	23	Middle Tower
209	32	IEEE 802.1 p, IEEE 802.1 q, IEEE 802.3, IEEE 802.3 ab, IEEE 802.3 u, IEEE 802.3 x
210	34	2560 x 1440
211	32	Wi-Fi 7, Bluetooth 5.4
212	36	200
213	8	PCI Express 4.0 x16
214	32	LAN
215	36	300
216	36	350
217	36	250 cd/m²
218	36	300 cd/m²
219	34	3440 x 1440
220	32	Wi-Fi 4
221	32	Wi-Fi 6
222	32	Wi-Fi 4, Wi-Fi 5, Wi-Fi 6
223	33	USB
224	34	2560 x 1440 (WQHD)
225	36	450
226	30	Powietrzne
227	32	Wi-Fi 7
228	23	Micro Tower
229	32	Wi-Fi 6, Wi-Fi 6, Bluetooth 5.2
230	33	PCI-E
231	32	Wi-Fi 6, Bluetooth 5.3
232	8	 PCIe 5.0 x16
233	34	3840 x 2160 (UHD 4K)
234	32	IEEE 802.3, IEEE 802.3 ab, IEEE 802.3 an, IEEE 802.3 az, IEEE 802.3 bz, IEEE 802.3 u, IEEE 802.3 x
235	36	1300
236	36	400
237	34	1920 x 1080
238	34	3840 x 2160
239	32	Wi-Fi 6E, Bluetooth 5.2
240	8	PCIe 5.0 x16 
241	32	Wi-Fi 6, Bluetooth 5.0
242	30	Wodne
243	32	Wi-Fi 5
244	36	250
245	32	IEEE 802.3, IEEE 802.3 ab, IEEE 802.3 bz, IEEE 802.3 u, IEEE 802.3 x
\.


--
-- TOC entry 5856 (class 0 OID 34212)
-- Dependencies: 267
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.brands (id, name) FROM stdin;
1	AMD
2	Intel
3	Nvidia
4	ASUS
5	MSI
6	Gigabyte
7	Palit
8	Zotac
9	Sapphire
10	PowerColor
11	Gainward
12	PNY
13	Inno3D
14	ASRock
15	EVGA
16	NZXT
17	Samsung
18	Kingston
19	Corsair
20	G.Skill
21	Crucial
22	Lexar
23	ADATA
24	XPG
25	Western Digital
26	Seagate
27	Goodram
28	Endorfy
29	be quiet
30	Seasonic
31	Lian Li
32	Noctua
33	Cooler Master
34	Fractal Design
35	Patriot
36	iiyams
37	Acer
38	Alienware
39	Lenovo
40	DELL
41	KOORUI
42	Xiaomi
43	TP-Link
44	Cudy
45	Thermalright
46	Krux
47	Genesis
48	Savio
49	SMX
50	Deepcool
51	DarkFlash
\.


--
-- TOC entry 5858 (class 0 OID 34218)
-- Dependencies: 269
-- Data for Name: cart_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cart_items (id, user_id, product_id, quantity) FROM stdin;
\.


--
-- TOC entry 5860 (class 0 OID 34224)
-- Dependencies: 271
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories (id, name, parrent_id) FROM stdin;
3	Płyta Główna	\N
4	Ram	\N
1	Procesor	\N
2	Karta Graficzna	\N
5	Dysk	\N
6	Zasilacz\n	\N
7	Obudowa	\N
8	Myszka	\N
9	Klawiatura	\N
10	Słuchawki	\N
11	Głośniki	\N
12	Chłodzenie Procesora	\N
13	Karty sieciowe	\N
14	Monitor	\N
\.


--
-- TOC entry 5862 (class 0 OID 34230)
-- Dependencies: 273
-- Data for Name: category_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.category_attributes (id, category_id, attribute_id, is_required) FROM stdin;
48	1	7	t
49	1	38	t
50	12	39	t
1	1	1	t
7	2	8	t
8	2	9	t
9	2	10	t
10	3	1	t
11	3	11	t
12	3	12	t
13	3	13	t
14	4	13	t
15	4	14	t
16	4	15	t
17	4	16	f
18	5	17	t
19	5	18	t
20	5	19	t
21	6	20	t
22	6	21	t
23	6	22	t
24	7	23	t
25	7	24	t
26	7	25	t
27	7	12	t
28	8	26	t
29	8	27	t
30	9	26	t
31	9	28	t
32	10	26	t
33	10	29	f
34	11	29	t
36	12	30	t
37	12	31	f
38	13	32	t
39	13	33	t
40	14	34	t
41	14	35	t
42	14	36	t
43	14	37	t
2	1	2	t
3	1	3	t
4	1	4	t
5	1	5	t
6	1	6	t
\.


--
-- TOC entry 5864 (class 0 OID 34238)
-- Dependencies: 275
-- Data for Name: complaints; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.complaints (id, order_id, reason, description, status) FROM stdin;
\.


--
-- TOC entry 5866 (class 0 OID 34246)
-- Dependencies: 277
-- Data for Name: order_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.order_items (id, order_id, product_id, quantity, unit_price) FROM stdin;
\.


--
-- TOC entry 5868 (class 0 OID 34253)
-- Dependencies: 279
-- Data for Name: orders; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.orders (id, user_id, shipping_method_id, tracking_status, shipping_cost, created_at, shipping_first_name, shipping_street, shipping_city, shipping_postal_code, shipping_phone, shipping_last_name) FROM stdin;
\.


--
-- TOC entry 5870 (class 0 OID 34261)
-- Dependencies: 281
-- Data for Name: product_attributes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_attributes (id, product_id, attribute_cathegory_id, attribute_value_id, value_text, value_number, value_boolean) FROM stdin;
1	1	1	1	\N	\N	\N
2	1	2	9	\N	\N	\N
37	14	8	213	PCI Express 4.0 x16	\N	\N
40	15	8	213	PCI Express 4.0 x16	\N	\N
133	37	8	232	 PCIe 5.0 x16	\N	\N
166	44	8	240	PCIe 5.0 x16 	\N	\N
9	2	1	1	\N	\N	\N
10	2	2	9	\N	\N	\N
487	142	32	231	Wi-Fi 6, Bluetooth 5.3	\N	\N
488	142	33	230	PCI-E	\N	\N
489	143	32	243	Wi-Fi 5	\N	\N
490	143	33	223	USB	\N	\N
16	3	1	1	\N	\N	\N
17	3	2	9	\N	\N	\N
828	224	30	242	Wodne	\N	\N
829	225	30	242	Wodne	\N	\N
830	226	30	242	Wodne	\N	\N
831	227	30	226	Powietrzne	\N	\N
23	4	1	1	\N	\N	\N
832	228	30	242	Wodne	\N	\N
833	229	30	242	Wodne	\N	\N
834	230	30	242	Wodne	\N	\N
835	231	30	242	Wodne	\N	\N
24	4	2	10	\N	\N	\N
30	5	1	1	\N	\N	\N
31	5	2	10	\N	\N	\N
836	232	30	242	Wodne	\N	\N
837	233	30	242	Wodne	\N	\N
838	234	30	242	Wodne	\N	\N
839	235	30	226	Powietrzne	\N	\N
38	14	9	56	\N	\N	\N
39	14	10	22	\N	\N	\N
41	15	9	56	\N	\N	\N
42	15	10	22	\N	\N	\N
43	16	17	41	\N	\N	\N
45	16	19	43	\N	\N	\N
840	236	30	226	Powietrzne	\N	\N
46	17	17	41	\N	\N	\N
7	1	7	202	\N	\N	f
48	17	19	45	\N	\N	\N
49	18	17	41	\N	\N	\N
15	2	7	202	\N	\N	f
51	18	19	45	\N	\N	\N
52	19	17	41	\N	\N	\N
22	3	7	202	\N	\N	f
54	19	19	45	\N	\N	\N
55	20	17	41	\N	\N	\N
29	4	7	202	\N	\N	f
57	20	19	45	\N	\N	\N
58	21	17	41	\N	\N	\N
36	5	7	202	\N	\N	f
60	21	19	45	\N	\N	\N
61	22	17	41	\N	\N	\N
80	26	7	202	\N	\N	f
63	22	19	45	\N	\N	\N
64	23	13	38	\N	\N	\N
87	27	7	202	\N	\N	f
98	29	7	204	\N	\N	t
68	24	17	41	\N	\N	\N
105	30	7	204	\N	\N	t
70	24	19	45	\N	\N	\N
71	25	17	41	\N	\N	\N
128	35	7	204	\N	\N	t
73	25	19	45	\N	\N	\N
142	38	7	204	\N	\N	t
74	26	1	5	\N	\N	\N
75	26	2	16	\N	\N	\N
156	41	7	202	\N	\N	f
81	27	1	5	\N	\N	\N
82	27	2	16	\N	\N	\N
88	28	13	38	\N	\N	\N
92	29	1	2	\N	\N	\N
93	29	2	9	\N	\N	\N
99	30	1	2	\N	\N	\N
106	31	13	37	\N	\N	\N
110	32	13	38	\N	\N	\N
114	33	13	38	\N	\N	\N
118	34	13	38	\N	\N	\N
122	35	1	2	\N	\N	\N
123	35	2	9	\N	\N	\N
129	36	13	38	\N	\N	\N
134	37	9	56	\N	\N	\N
135	37	10	24	\N	\N	\N
136	38	1	2	\N	\N	\N
137	38	2	10	\N	\N	\N
100	30	2	10	\N	\N	\N
143	39	13	37	\N	\N	\N
147	40	13	38	\N	\N	\N
151	41	1	4	\N	\N	\N
152	41	2	14	\N	\N	\N
157	42	13	38	\N	\N	\N
161	43	13	37	\N	\N	\N
167	44	9	55	\N	\N	\N
168	44	10	21	\N	\N	\N
170	45	9	55	\N	\N	\N
171	45	10	21	\N	\N	\N
173	46	9	56	\N	\N	\N
174	46	10	24	\N	\N	\N
176	47	9	55	\N	\N	\N
177	47	10	21	\N	\N	\N
179	48	9	55	\N	\N	\N
180	48	10	21	\N	\N	\N
182	49	9	55	\N	\N	\N
183	49	10	21	\N	\N	\N
185	50	9	55	\N	\N	\N
186	50	10	21	\N	\N	\N
188	51	9	55	\N	\N	\N
189	51	10	21	\N	\N	\N
191	52	9	55	\N	\N	\N
192	52	10	21	\N	\N	\N
194	53	9	57	\N	\N	\N
195	53	10	25	\N	\N	\N
197	54	9	56	\N	\N	\N
198	54	10	24	\N	\N	\N
200	55	9	55	\N	\N	\N
201	55	10	21	\N	\N	\N
203	56	9	55	\N	\N	\N
204	56	10	21	\N	\N	\N
206	57	9	56	\N	\N	\N
207	57	10	24	\N	\N	\N
209	58	9	56	\N	\N	\N
210	58	10	24	\N	\N	\N
212	59	9	55	\N	\N	\N
213	59	10	21	\N	\N	\N
215	60	9	56	\N	\N	\N
216	60	10	24	\N	\N	\N
218	61	9	56	\N	\N	\N
219	61	10	23	\N	\N	\N
221	62	9	55	\N	\N	\N
222	62	10	21	\N	\N	\N
224	63	9	56	\N	\N	\N
225	63	10	24	\N	\N	\N
227	64	9	55	\N	\N	\N
228	64	10	21	\N	\N	\N
230	65	9	55	\N	\N	\N
231	65	10	21	\N	\N	\N
233	66	9	55	\N	\N	\N
234	66	10	21	\N	\N	\N
236	67	9	55	\N	\N	\N
237	67	10	21	\N	\N	\N
239	68	9	55	\N	\N	\N
240	68	10	21	\N	\N	\N
242	69	9	55	\N	\N	\N
243	69	10	21	\N	\N	\N
245	70	9	55	\N	\N	\N
246	70	10	21	\N	\N	\N
247	71	13	38	\N	\N	\N
169	45	8	240	PCIe 5.0 x16 	\N	\N
172	46	8	240	PCIe 5.0 x16 	\N	\N
175	47	8	240	PCIe 5.0 x16 	\N	\N
251	72	13	38	\N	\N	\N
178	48	8	232	 PCIe 5.0 x16	\N	\N
181	49	8	232	 PCIe 5.0 x16	\N	\N
184	50	8	232	 PCIe 5.0 x16	\N	\N
187	51	8	232	 PCIe 5.0 x16	\N	\N
190	52	8	232	 PCIe 5.0 x16	\N	\N
259	74	13	38	\N	\N	\N
193	53	8	232	 PCIe 5.0 x16	\N	\N
196	54	8	232	 PCIe 5.0 x16	\N	\N
199	55	8	232	 PCIe 5.0 x16	\N	\N
263	75	13	38	\N	\N	\N
202	56	8	232	 PCIe 5.0 x16	\N	\N
205	57	8	232	 PCIe 5.0 x16	\N	\N
208	58	8	232	 PCIe 5.0 x16	\N	\N
267	76	13	37	\N	\N	\N
211	59	8	232	 PCIe 5.0 x16	\N	\N
214	60	8	232	 PCIe 5.0 x16	\N	\N
217	61	8	232	 PCIe 5.0 x16	\N	\N
271	77	13	38	\N	\N	\N
220	62	8	232	 PCIe 5.0 x16	\N	\N
223	63	8	232	 PCIe 5.0 x16	\N	\N
226	64	8	232	 PCIe 5.0 x16	\N	\N
275	78	13	38	\N	\N	\N
229	65	8	232	 PCIe 5.0 x16	\N	\N
232	66	8	232	 PCIe 5.0 x16	\N	\N
235	67	8	232	 PCIe 5.0 x16	\N	\N
279	80	13	38	\N	\N	\N
238	68	8	232	 PCIe 5.0 x16	\N	\N
241	69	8	232	 PCIe 5.0 x16	\N	\N
244	70	8	232	 PCIe 5.0 x16	\N	\N
255	73	34	233	3840 x 2160 (UHD 4K)	\N	\N
257	73	36	217	250 cd/m²	\N	\N
287	82	13	38	\N	\N	\N
283	81	34	233	3840 x 2160 (UHD 4K)	\N	\N
285	81	36	217	250 cd/m²	\N	\N
327	92	34	237	1920 x 1080	\N	\N
291	83	13	37	\N	\N	\N
329	92	36	217	250 cd/m²	\N	\N
295	84	13	37	\N	\N	\N
299	85	13	37	\N	\N	\N
303	86	13	38	\N	\N	\N
307	87	13	38	\N	\N	\N
311	88	13	38	\N	\N	\N
315	89	13	37	\N	\N	\N
319	90	13	38	\N	\N	\N
323	91	13	38	\N	\N	\N
331	93	13	38	\N	\N	\N
335	94	34	210	2560 x 1440	\N	\N
337	94	36	218	300 cd/m²	\N	\N
339	95	34	224	2560 x 1440 (WQHD)	\N	\N
341	95	36	207	400 cd/m²	\N	\N
343	96	34	237	1920 x 1080	\N	\N
345	96	36	218	300 cd/m²	\N	\N
347	97	34	237	1920 x 1080	\N	\N
349	97	36	218	300 cd/m²	\N	\N
351	98	34	233	3840 x 2160 (UHD 4K)	\N	\N
353	98	36	225	450	\N	\N
355	99	34	233	3840 x 2160 (UHD 4K)	\N	\N
357	99	36	225	450	\N	\N
359	100	34	210	2560 x 1440	\N	\N
361	100	36	212	200	\N	\N
363	101	34	237	1920 x 1080	\N	\N
365	101	36	215	300	\N	\N
367	102	34	210	2560 x 1440	\N	\N
369	102	36	216	350	\N	\N
371	103	34	224	2560 x 1440 (WQHD)	\N	\N
373	103	36	236	400	\N	\N
375	104	34	210	2560 x 1440	\N	\N
377	104	36	235	1300	\N	\N
379	105	34	237	1920 x 1080	\N	\N
381	105	36	215	300	\N	\N
383	106	34	237	1920 x 1080	\N	\N
385	106	36	244	250	\N	\N
387	107	34	237	1920 x 1080	\N	\N
389	107	36	244	250	\N	\N
391	108	34	224	2560 x 1440 (WQHD)	\N	\N
393	108	36	216	350	\N	\N
398	110	34	219	3440 x 1440	\N	\N
400	110	36	216	350	\N	\N
402	111	34	238	3840 x 2160	\N	\N
404	111	36	225	450	\N	\N
396	109	21	48	\N	\N	\N
397	109	22	51	\N	\N	\N
412	114	32	239	Wi-Fi 6E, Bluetooth 5.2	\N	\N
413	114	33	230	PCI-E	\N	\N
423	118	32	243	Wi-Fi 5	\N	\N
424	118	33	223	USB	\N	\N
437	123	32	214	LAN	\N	\N
407	112	21	48	\N	\N	\N
408	112	22	51	\N	\N	\N
438	123	33	230	PCI-E	\N	\N
410	113	21	49	\N	\N	\N
411	113	22	51	\N	\N	\N
445	126	32	227	Wi-Fi 7	\N	\N
415	115	21	48	\N	\N	\N
416	115	22	51	\N	\N	\N
446	126	33	223	USB	\N	\N
418	116	21	48	\N	\N	\N
419	116	22	51	\N	\N	\N
450	128	32	211	Wi-Fi 7, Bluetooth 5.4	\N	\N
421	117	21	46	\N	\N	\N
422	117	22	51	\N	\N	\N
451	128	33	230	PCI-E	\N	\N
426	119	21	48	\N	\N	\N
427	119	22	51	\N	\N	\N
464	133	32	209	IEEE 802.1 p, IEEE 802.1 q, IEEE 802.3, IEEE 802.3 ab, IEEE 802.3 u, IEEE 802.3 x	\N	\N
429	120	21	50	\N	\N	\N
430	120	22	51	\N	\N	\N
465	133	33	230	PCI-E	\N	\N
432	121	21	46	\N	\N	\N
433	121	22	51	\N	\N	\N
469	135	32	241	Wi-Fi 6, Bluetooth 5.0	\N	\N
435	122	21	48	\N	\N	\N
436	122	22	51	\N	\N	\N
470	135	33	230	PCI-E	\N	\N
440	124	21	46	\N	\N	\N
441	124	22	51	\N	\N	\N
482	140	32	234	IEEE 802.3, IEEE 802.3 ab, IEEE 802.3 an, IEEE 802.3 az, IEEE 802.3 bz, IEEE 802.3 u, IEEE 802.3 x	\N	\N
443	125	21	48	\N	\N	\N
444	125	22	51	\N	\N	\N
483	140	33	230	PCI-E	\N	\N
448	127	21	48	\N	\N	\N
449	127	22	51	\N	\N	\N
630	176	7	204	\N	\N	t
453	129	21	46	\N	\N	\N
454	129	22	51	\N	\N	\N
631	26	38	203	\N	\N	f
456	130	21	46	\N	\N	\N
457	130	22	51	\N	\N	\N
633	29	38	203	\N	\N	f
459	131	21	50	\N	\N	\N
460	131	22	51	\N	\N	\N
462	132	21	49	\N	\N	\N
463	132	22	51	\N	\N	\N
467	134	21	48	\N	\N	\N
468	134	22	51	\N	\N	\N
472	136	21	50	\N	\N	\N
473	136	22	51	\N	\N	\N
480	139	21	48	\N	\N	\N
481	139	22	51	\N	\N	\N
485	141	21	48	\N	\N	\N
486	141	22	51	\N	\N	\N
492	144	21	48	\N	\N	\N
493	144	22	51	\N	\N	\N
11	2	3	91	\N	6	\N
494	145	32	229	Wi-Fi 6, Wi-Fi 6, Bluetooth 5.2	\N	\N
499	147	21	48	\N	\N	\N
500	147	22	51	\N	\N	\N
495	145	33	230	PCI-E	\N	\N
502	148	21	50	\N	\N	\N
503	148	22	51	\N	\N	\N
496	146	32	222	Wi-Fi 4, Wi-Fi 5, Wi-Fi 6	\N	\N
505	149	21	49	\N	\N	\N
506	149	22	51	\N	\N	\N
497	146	33	223	USB	\N	\N
508	150	21	46	\N	\N	\N
509	150	22	51	\N	\N	\N
519	154	32	243	Wi-Fi 5	\N	\N
511	151	21	46	\N	\N	\N
512	151	22	51	\N	\N	\N
520	154	33	223	USB	\N	\N
514	152	21	46	\N	\N	\N
515	152	22	51	\N	\N	\N
521	155	32	221	Wi-Fi 6	\N	\N
517	153	21	48	\N	\N	\N
518	153	22	51	\N	\N	\N
522	155	33	223	USB	\N	\N
538	163	21	46	\N	\N	\N
539	163	22	51	\N	\N	\N
540	164	1	2	\N	\N	\N
541	164	2	9	\N	\N	\N
523	156	32	243	Wi-Fi 5	\N	\N
524	156	33	223	USB	\N	\N
525	157	32	220	Wi-Fi 4	\N	\N
526	157	33	230	PCI-E	\N	\N
547	165	1	2	\N	\N	\N
548	165	2	10	\N	\N	\N
527	158	32	211	Wi-Fi 7, Bluetooth 5.4	\N	\N
528	158	33	230	PCI-E	\N	\N
529	159	32	245	IEEE 802.3, IEEE 802.3 ab, IEEE 802.3 bz, IEEE 802.3 u, IEEE 802.3 x	\N	\N
530	159	33	230	PCI-E	\N	\N
554	166	1	2	\N	\N	\N
555	166	2	11	\N	\N	\N
531	160	32	220	Wi-Fi 4	\N	\N
532	160	33	230	PCI-E	\N	\N
533	161	32	220	Wi-Fi 4	\N	\N
534	161	33	223	USB	\N	\N
561	167	1	2	\N	\N	\N
562	167	2	9	\N	\N	\N
535	162	32	220	Wi-Fi 4	\N	\N
536	162	33	223	USB	\N	\N
546	164	7	204	\N	\N	t
553	165	7	204	\N	\N	t
568	168	1	2	\N	\N	\N
569	168	2	10	\N	\N	\N
560	166	7	204	\N	\N	t
567	167	7	204	\N	\N	t
574	168	7	204	\N	\N	t
581	169	7	204	\N	\N	t
575	169	1	4	\N	\N	\N
576	169	2	15	\N	\N	\N
588	170	7	202	\N	\N	f
595	171	7	202	\N	\N	f
602	172	7	202	\N	\N	f
609	173	7	202	\N	\N	f
582	170	1	4	\N	\N	\N
583	170	2	15	\N	\N	\N
616	174	7	204	\N	\N	t
623	175	7	202	\N	\N	f
635	35	38	203	\N	\N	f
636	38	38	203	\N	\N	f
589	171	1	4	\N	\N	\N
590	171	2	13	\N	\N	\N
639	3	38	203	\N	\N	f
640	5	38	203	\N	\N	f
641	4	38	203	\N	\N	f
642	41	38	203	\N	\N	f
596	172	1	5	\N	\N	\N
597	172	2	17	\N	\N	\N
643	164	38	203	\N	\N	f
644	166	38	203	\N	\N	f
645	165	38	203	\N	\N	f
646	167	38	203	\N	\N	f
603	173	1	2	\N	\N	\N
604	173	2	9	\N	\N	\N
647	168	38	203	\N	\N	f
648	169	38	203	\N	\N	f
649	170	38	203	\N	\N	f
651	172	38	203	\N	\N	f
610	174	1	2	\N	\N	\N
611	174	2	9	\N	\N	\N
654	175	38	203	\N	\N	f
662	177	7	202	\N	\N	f
663	177	38	203	\N	\N	f
670	178	7	202	\N	\N	f
617	175	1	4	\N	\N	\N
618	175	2	13	\N	\N	\N
671	178	38	203	\N	\N	f
624	176	1	5	\N	\N	\N
625	176	2	16	\N	\N	\N
656	177	1	5	\N	\N	\N
657	177	2	16	\N	\N	\N
664	178	1	4	\N	\N	\N
665	178	2	13	\N	\N	\N
672	179	1	4	\N	\N	\N
673	179	2	13	\N	\N	\N
816	212	30	242	Wodne	\N	\N
817	213	30	226	Powietrzne	\N	\N
818	214	30	226	Powietrzne	\N	\N
819	215	30	242	Wodne	\N	\N
680	180	1	4	\N	\N	\N
681	180	2	14	\N	\N	\N
820	216	30	242	Wodne	\N	\N
821	217	30	242	Wodne	\N	\N
822	218	30	226	Powietrzne	\N	\N
823	219	30	226	Powietrzne	\N	\N
688	181	1	5	\N	\N	\N
689	181	2	18	\N	\N	\N
824	220	30	242	Wodne	\N	\N
825	221	30	242	Wodne	\N	\N
826	222	30	226	Powietrzne	\N	\N
827	223	30	226	Powietrzne	\N	\N
696	182	1	5	\N	\N	\N
697	182	11	58	\N	\N	\N
698	182	12	33	\N	\N	\N
699	182	13	38	\N	\N	\N
700	183	1	2	\N	\N	\N
701	183	11	59	\N	\N	\N
702	183	12	33	\N	\N	\N
703	183	13	38	\N	\N	\N
704	184	1	2	\N	\N	\N
705	184	11	59	\N	\N	\N
706	184	12	34	\N	\N	\N
707	184	13	38	\N	\N	\N
708	185	1	4	\N	\N	\N
709	185	11	31	\N	\N	\N
710	185	12	34	\N	\N	\N
711	185	13	37	\N	\N	\N
712	186	1	1	\N	\N	\N
713	186	11	27	\N	\N	\N
714	186	12	34	\N	\N	\N
715	186	13	37	\N	\N	\N
716	187	1	2	\N	\N	\N
717	187	11	29	\N	\N	\N
718	187	12	33	\N	\N	\N
719	187	13	38	\N	\N	\N
720	188	1	4	\N	\N	\N
721	188	11	32	\N	\N	\N
722	188	12	33	\N	\N	\N
723	188	13	38	\N	\N	\N
724	189	1	2	\N	\N	\N
725	189	11	29	\N	\N	\N
726	189	12	33	\N	\N	\N
727	189	13	38	\N	\N	\N
728	190	1	1	\N	\N	\N
729	190	11	27	\N	\N	\N
730	190	12	33	\N	\N	\N
731	190	13	37	\N	\N	\N
732	191	1	4	\N	\N	\N
733	191	11	31	\N	\N	\N
734	191	12	34	\N	\N	\N
735	191	13	37	\N	\N	\N
736	192	1	2	\N	\N	\N
737	192	11	29	\N	\N	\N
738	192	12	33	\N	\N	\N
739	192	13	38	\N	\N	\N
740	193	1	2	\N	\N	\N
741	193	11	29	\N	\N	\N
742	193	12	34	\N	\N	\N
743	193	13	38	\N	\N	\N
744	194	1	4	\N	\N	\N
745	194	11	31	\N	\N	\N
746	194	12	34	\N	\N	\N
747	194	13	38	\N	\N	\N
748	195	1	5	\N	\N	\N
749	195	11	58	\N	\N	\N
750	195	12	34	\N	\N	\N
751	195	13	38	\N	\N	\N
752	196	1	2	\N	\N	\N
753	196	11	58	\N	\N	\N
754	196	12	33	\N	\N	\N
755	196	13	38	\N	\N	\N
756	197	1	1	\N	\N	\N
757	197	11	27	\N	\N	\N
758	197	12	33	\N	\N	\N
759	197	13	37	\N	\N	\N
760	198	1	4	\N	\N	\N
761	198	11	31	\N	\N	\N
762	198	12	34	\N	\N	\N
763	198	13	38	\N	\N	\N
764	199	1	4	\N	\N	\N
765	199	11	32	\N	\N	\N
766	199	12	33	\N	\N	\N
767	199	13	38	\N	\N	\N
768	200	1	4	\N	\N	\N
769	200	11	32	\N	\N	\N
770	200	12	33	\N	\N	\N
771	200	13	38	\N	\N	\N
772	201	1	1	\N	\N	\N
773	201	11	27	\N	\N	\N
774	201	12	34	\N	\N	\N
775	201	13	37	\N	\N	\N
776	202	1	1	\N	\N	\N
777	202	11	27	\N	\N	\N
778	202	12	34	\N	\N	\N
779	202	13	37	\N	\N	\N
780	203	1	5	\N	\N	\N
781	203	11	58	\N	\N	\N
782	203	12	34	\N	\N	\N
783	203	13	38	\N	\N	\N
784	204	1	5	\N	\N	\N
785	204	11	58	\N	\N	\N
786	204	12	33	\N	\N	\N
787	204	13	38	\N	\N	\N
788	205	1	5	\N	\N	\N
789	205	11	58	\N	\N	\N
790	205	12	33	\N	\N	\N
791	205	13	38	\N	\N	\N
792	206	1	5	\N	\N	\N
793	206	11	58	\N	\N	\N
794	206	12	33	\N	\N	\N
795	206	13	38	\N	\N	\N
796	207	1	5	\N	\N	\N
797	207	11	58	\N	\N	\N
798	207	12	33	\N	\N	\N
799	207	13	38	\N	\N	\N
800	208	1	2	\N	\N	\N
801	208	11	59	\N	\N	\N
802	208	12	34	\N	\N	\N
803	208	13	38	\N	\N	\N
804	209	1	2	\N	\N	\N
805	209	11	59	\N	\N	\N
806	209	12	34	\N	\N	\N
807	209	13	38	\N	\N	\N
808	210	1	4	\N	\N	\N
809	210	11	32	\N	\N	\N
810	210	12	33	\N	\N	\N
811	210	13	38	\N	\N	\N
812	211	1	1	\N	\N	\N
813	211	11	27	\N	\N	\N
814	211	12	33	\N	\N	\N
815	211	13	37	\N	\N	\N
678	179	7	202	\N	\N	f
679	179	38	203	\N	\N	f
686	180	7	202	\N	\N	f
687	180	38	203	\N	\N	f
694	181	7	204	\N	\N	t
632	27	38	205	\N	\N	t
634	30	38	205	\N	\N	t
637	1	38	205	\N	\N	t
638	2	38	205	\N	\N	t
650	171	38	205	\N	\N	t
652	173	38	205	\N	\N	t
653	174	38	205	\N	\N	t
655	176	38	205	\N	\N	t
695	181	38	205	\N	\N	t
3	1	3	91	\N	\N	\N
861	237	30	242	Wodne	\N	\N
862	238	30	242	Wodne	\N	\N
863	239	30	242	Wodne	\N	\N
864	240	30	242	Wodne	\N	\N
865	241	30	242	Wodne	\N	\N
876	242	23	206	Full Tower	\N	\N
880	243	23	208	Middle Tower	\N	\N
884	244	23	208	Middle Tower	\N	\N
888	245	23	208	Middle Tower	\N	\N
892	246	23	208	Middle Tower	\N	\N
896	247	23	208	Middle Tower	\N	\N
900	248	23	228	Micro Tower	\N	\N
904	249	23	208	Middle Tower	\N	\N
908	250	23	208	Middle Tower	\N	\N
912	251	23	208	Middle Tower	\N	\N
916	252	23	208	Middle Tower	\N	\N
920	253	23	208	Middle Tower	\N	\N
924	254	23	208	Middle Tower	\N	\N
928	255	23	208	Middle Tower	\N	\N
932	256	23	208	Middle Tower	\N	\N
936	257	23	208	Middle Tower	\N	\N
940	258	23	228	Micro Tower	\N	\N
944	259	23	208	Middle Tower	\N	\N
948	260	23	208	Middle Tower	\N	\N
952	261	23	208	Middle Tower	\N	\N
956	262	23	208	Middle Tower	\N	\N
960	263	23	206	Full Tower	\N	\N
964	264	23	228	Micro Tower	\N	\N
968	265	23	208	Middle Tower	\N	\N
879	242	12	33	\N	\N	\N
972	266	23	228	Micro Tower	\N	\N
976	267	23	208	Middle Tower	\N	\N
883	243	12	33	\N	\N	\N
984	269	23	208	Middle Tower	\N	\N
988	270	23	208	Middle Tower	\N	\N
887	244	12	33	\N	\N	\N
992	271	23	208	Middle Tower	\N	\N
996	272	23	208	Middle Tower	\N	\N
891	245	12	33	\N	\N	\N
895	246	12	33	\N	\N	\N
899	247	12	33	\N	\N	\N
903	248	12	34	\N	\N	\N
907	249	12	33	\N	\N	\N
911	250	12	33	\N	\N	\N
915	251	12	33	\N	\N	\N
919	252	12	33	\N	\N	\N
923	253	12	33	\N	\N	\N
927	254	12	34	\N	\N	\N
931	255	12	34	\N	\N	\N
935	256	12	34	\N	\N	\N
939	257	12	35	\N	\N	\N
943	258	12	35	\N	\N	\N
947	259	12	34	\N	\N	\N
951	260	12	34	\N	\N	\N
955	261	12	33	\N	\N	\N
959	262	12	35	\N	\N	\N
963	263	12	35	\N	\N	\N
967	264	12	34	\N	\N	\N
971	265	12	35	\N	\N	\N
975	266	12	34	\N	\N	\N
979	267	12	34	\N	\N	\N
987	269	12	33	\N	\N	\N
991	270	12	36	\N	\N	\N
995	271	12	35	\N	\N	\N
999	272	12	34	\N	\N	\N
4	1	4	178	\N	12	\N
5	1	5	140	\N	3500	\N
6	1	6	185	\N	4400	\N
12	2	4	178	\N	12	\N
13	2	5	144	\N	3600	\N
14	2	6	87	\N	4200	\N
18	3	3	91	\N	6	\N
19	3	4	178	\N	12	\N
20	3	5	183	\N	3700	\N
21	3	6	63	\N	4700	\N
25	4	3	98	\N	8	\N
26	4	4	83	\N	16	\N
27	4	5	97	\N	3400	\N
28	4	6	72	\N	4600	\N
32	5	3	98	\N	8	\N
33	5	4	83	\N	16	\N
34	5	5	102	\N	3800	\N
35	5	6	63	\N	4700	\N
44	16	18	75	\N	512.0	\N
47	17	18	148	\N	4096000.0	\N
50	18	18	187	\N	2048000.0	\N
53	19	18	132	\N	1024000.0	\N
56	20	18	148	\N	4096000.0	\N
59	21	18	187	\N	2048000.0	\N
62	22	18	132	\N	1024000.0	\N
66	23	15	78	\N	6000.0	\N
67	23	16	186	\N	30.0	\N
69	24	18	62	\N	2000000.0	\N
72	25	18	93	\N	1000000.0	\N
65	23	14	173	\N	32	\N
76	26	3	191	\N	14.0	\N
77	26	4	177	\N	14.0	\N
78	26	5	162	\N	3600.0	\N
79	26	6	184	\N	5200.0	\N
83	27	3	74	\N	10.0	\N
84	27	4	165	\N	10.0	\N
85	27	5	77	\N	3300.0	\N
86	27	6	194	\N	4900.0	\N
89	28	14	94	\N	32.0	\N
90	28	15	113	\N	6400.0	\N
91	28	16	111	\N	32.0	\N
94	29	3	175	\N	6.0	\N
95	29	4	141	\N	12.0	\N
96	29	5	90	\N	4700.0	\N
97	29	6	107	\N	5300.0	\N
101	30	3	175	\N	6.0	\N
102	30	4	141	\N	12.0	\N
103	30	5	110	\N	3800.0	\N
104	30	6	131	\N	5100.0	\N
107	31	14	193	\N	16.0	\N
108	31	15	96	\N	3200.0	\N
109	31	16	159	\N	16.0	\N
111	32	14	94	\N	32.0	\N
112	32	15	78	\N	6000.0	\N
113	32	16	186	\N	30.0	\N
115	33	14	94	\N	32.0	\N
116	33	15	170	\N	5600.0	\N
117	33	16	89	\N	36.0	\N
119	34	14	94	\N	32.0	\N
120	34	15	78	\N	6000.0	\N
121	34	16	89	\N	36.0	\N
124	35	3	155	\N	8.0	\N
125	35	4	95	\N	16.0	\N
126	35	5	134	\N	4200.0	\N
127	35	6	61	\N	5000.0	\N
130	36	14	94	\N	32.0	\N
131	36	15	78	\N	6000.0	\N
132	36	16	186	\N	30.0	\N
138	38	3	155	\N	8.0	\N
139	38	4	95	\N	16.0	\N
140	38	5	90	\N	4700.0	\N
141	38	6	184	\N	5200.0	\N
144	39	14	94	\N	32.0	\N
145	39	15	96	\N	3200.0	\N
146	39	16	159	\N	16.0	\N
148	40	14	94	\N	32.0	\N
149	40	15	78	\N	6000.0	\N
150	40	16	186	\N	30.0	\N
153	41	4	100	\N	20.0	\N
155	41	6	67	\N	5600.0	\N
158	42	14	94	\N	32.0	\N
159	42	15	78	\N	6000.0	\N
160	42	16	89	\N	36.0	\N
162	43	14	94	\N	32.0	\N
163	43	15	96	\N	3200.0	\N
164	43	16	159	\N	16.0	\N
165	41	3	114	\N	20	\N
154	41	5	118	\N	3400.0	\N
248	71	14	94	\N	32.0	\N
249	71	15	78	\N	6000.0	\N
250	71	16	186	\N	30.0	\N
252	72	14	94	\N	32.0	\N
253	72	15	78	\N	6000.0	\N
254	72	16	186	\N	30.0	\N
256	73	35	73	\N	240.0	\N
258	73	37	71	\N	31.5	\N
260	74	14	193	\N	16.0	\N
261	74	15	170	\N	5600.0	\N
262	74	16	89	\N	36.0	\N
264	75	14	99	\N	64.0	\N
265	75	15	78	\N	6000.0	\N
266	75	16	186	\N	30.0	\N
268	76	14	94	\N	32.0	\N
269	76	15	139	\N	3600.0	\N
270	76	16	156	\N	18.0	\N
272	77	14	94	\N	32.0	\N
273	77	15	78	\N	6000.0	\N
274	77	16	89	\N	36.0	\N
276	78	14	94	\N	32.0	\N
277	78	15	78	\N	6000.0	\N
278	78	16	89	\N	36.0	\N
280	80	14	94	\N	32.0	\N
281	80	15	78	\N	6000.0	\N
282	80	16	186	\N	30.0	\N
284	81	35	73	\N	240.0	\N
286	81	37	71	\N	31.5	\N
288	82	14	99	\N	64.0	\N
289	82	15	78	\N	6000.0	\N
290	82	16	186	\N	30.0	\N
292	83	14	94	\N	32.0	\N
293	83	15	96	\N	3200.0	\N
294	83	16	130	\N	20.0	\N
296	84	14	193	\N	16.0	\N
297	84	15	139	\N	3600.0	\N
298	84	16	159	\N	16.0	\N
300	85	14	94	\N	32.0	\N
301	85	15	139	\N	3600.0	\N
302	85	16	159	\N	16.0	\N
304	86	14	94	\N	32.0	\N
305	86	15	78	\N	6000.0	\N
306	86	16	89	\N	36.0	\N
308	87	14	94	\N	32.0	\N
309	87	15	78	\N	6000.0	\N
310	87	16	89	\N	36.0	\N
312	88	14	193	\N	16.0	\N
313	88	15	170	\N	5600.0	\N
314	88	16	198	\N	46.0	\N
316	89	14	193	\N	16.0	\N
318	89	16	161	\N	17.0	\N
320	90	14	94	\N	32.0	\N
321	90	15	139	\N	3600.0	\N
322	90	16	89	\N	36.0	\N
324	91	14	94	\N	32.0	\N
325	91	15	78	\N	6000.0	\N
326	91	16	89	\N	36.0	\N
328	92	35	126	\N	100.0	\N
330	92	37	92	\N	23.8	\N
332	93	14	99	\N	64.0	\N
333	93	15	78	\N	6000.0	\N
334	93	16	186	\N	30.0	\N
336	94	35	151	\N	180.0	\N
338	94	37	149	\N	27.0	\N
340	95	35	151	\N	180.0	\N
342	95	37	149	\N	27.0	\N
344	96	35	73	\N	240.0	\N
346	96	37	82	\N	24.5	\N
348	97	35	73	\N	240.0	\N
350	97	37	82	\N	24.5	\N
352	98	35	73	\N	240.0	\N
354	98	37	71	\N	31.5	\N
356	99	35	73	\N	240.0	\N
358	99	37	71	\N	31.5	\N
360	100	35	151	\N	180.0	\N
362	100	37	149	\N	27.0	\N
364	101	35	73	\N	240.0	\N
366	101	37	92	\N	23.8	\N
368	102	35	146	\N	200.0	\N
370	102	37	149	\N	27.0	\N
317	89	15	139	\N	3600.0	\N
372	103	35	73	\N	240.0	\N
374	103	37	149	\N	27.0	\N
376	104	35	73	\N	240.0	\N
378	104	37	197	\N	26.5	\N
380	105	35	145	\N	320.0	\N
382	105	37	82	\N	24.5	\N
384	106	35	126	\N	100.0	\N
386	106	37	92	\N	23.8	\N
388	107	35	126	\N	100.0	\N
390	107	37	92	\N	23.8	\N
392	108	35	146	\N	200.0	\N
394	108	37	149	\N	27.0	\N
395	109	20	81	\N	850.0	\N
399	110	35	151	\N	180.0	\N
401	110	37	190	\N	34.0	\N
403	111	35	86	\N	144.0	\N
405	111	37	149	\N	27.0	\N
406	112	20	81	\N	850.0	\N
409	113	20	201	\N	1000.0	\N
414	115	20	201	\N	1000.0	\N
417	116	20	108	\N	750.0	\N
420	117	20	108	\N	750.0	\N
425	119	20	108	\N	750.0	\N
428	120	20	81	\N	850.0	\N
431	121	20	196	\N	650.0	\N
434	122	20	81	\N	850.0	\N
439	124	20	64	\N	550.0	\N
442	125	20	108	\N	750.0	\N
447	127	20	81	\N	850.0	\N
452	129	20	181	\N	600.0	\N
455	130	20	64	\N	550.0	\N
458	131	20	201	\N	1000.0	\N
461	132	20	201	\N	1000.0	\N
466	134	20	196	\N	650.0	\N
471	136	20	189	\N	1200.0	\N
479	139	20	201	\N	1000.0	\N
484	141	20	81	\N	850.0	\N
491	144	20	81	\N	850.0	\N
498	147	20	108	\N	750.0	\N
501	148	20	129	\N	1600.0	\N
504	149	20	81	\N	850.0	\N
507	150	20	64	\N	550.0	\N
510	151	20	196	\N	650.0	\N
513	152	20	108	\N	750.0	\N
516	153	20	81	\N	850.0	\N
537	163	20	196	\N	650.0	\N
542	164	3	175	\N	6.0	\N
543	164	4	141	\N	12.0	\N
544	164	5	133	\N	4000.0	\N
545	164	6	167	\N	4500.0	\N
549	165	3	155	\N	8.0	\N
550	165	4	95	\N	16.0	\N
551	165	5	110	\N	3800.0	\N
552	165	6	122	\N	5500.0	\N
556	166	3	136	\N	16.0	\N
557	166	4	66	\N	32.0	\N
558	166	5	70	\N	4300.0	\N
559	166	6	166	\N	5700.0	\N
563	167	3	175	\N	6.0	\N
564	167	4	141	\N	12.0	\N
565	167	5	109	\N	3900.0	\N
566	167	6	103	\N	5400.0	\N
570	168	3	155	\N	8.0	\N
571	168	4	95	\N	16.0	\N
572	168	5	90	\N	4700.0	\N
573	168	6	67	\N	5600.0	\N
577	169	3	153	\N	24.0	\N
578	169	4	66	\N	32.0	\N
579	169	5	115	\N	3200.0	\N
580	169	6	195	\N	6000.0	\N
584	170	3	153	\N	24.0	\N
585	170	4	66	\N	32.0	\N
586	170	5	115	\N	3200.0	\N
587	170	6	195	\N	6000.0	\N
591	171	3	175	\N	6.0	\N
592	171	4	141	\N	12.0	\N
593	171	5	119	\N	2500.0	\N
594	171	6	138	\N	4400.0	\N
598	172	3	188	\N	20.0	\N
599	172	4	100	\N	20.0	\N
600	172	5	77	\N	3300.0	\N
601	172	6	122	\N	5500.0	\N
605	173	3	175	\N	6.0	\N
606	173	4	141	\N	12.0	\N
607	173	5	134	\N	4200.0	\N
608	173	6	169	\N	4700.0	\N
612	174	3	175	\N	6.0	\N
613	174	4	141	\N	12.0	\N
614	174	5	127	\N	3500.0	\N
615	174	6	61	\N	5000.0	\N
619	175	3	74	\N	10.0	\N
620	175	4	95	\N	16.0	\N
621	175	5	119	\N	2500.0	\N
622	175	6	169	\N	4700.0	\N
626	176	3	74	\N	10.0	\N
627	176	4	165	\N	10.0	\N
628	176	5	77	\N	3300.0	\N
629	176	6	194	\N	4900.0	\N
658	177	3	158	\N	18.0	\N
659	177	4	163	\N	18.0	\N
660	177	5	134	\N	4200.0	\N
661	177	6	184	\N	5200.0	\N
666	178	3	191	\N	14.0	\N
667	178	4	100	\N	20.0	\N
668	178	5	127	\N	3500.0	\N
669	178	6	107	\N	5300.0	\N
674	179	3	74	\N	10.0	\N
675	179	4	95	\N	16.0	\N
676	179	5	128	\N	3700.0	\N
677	179	6	194	\N	4900.0	\N
682	180	3	160	\N	12.0	\N
683	180	4	100	\N	20.0	\N
684	180	5	162	\N	3600.0	\N
685	180	6	61	\N	5000.0	\N
690	181	3	153	\N	24.0	\N
691	181	4	137	\N	24.0	\N
692	181	5	119	\N	2500.0	\N
693	181	6	67	\N	5600.0	\N
841	212	39	106	\N	280	\N
842	213	39	147	\N	220	\N
843	214	39	179	\N	180	\N
844	215	39	182	\N	320	\N
845	216	39	65	\N	260	\N
846	217	39	182	\N	320	\N
847	218	39	171	\N	200	\N
848	219	39	164	\N	150	\N
849	220	39	125	\N	300	\N
850	221	39	65	\N	260	\N
851	222	39	105	\N	250	\N
852	223	39	171	\N	200	\N
853	225	39	125	\N	300	\N
854	226	39	65	\N	260	\N
855	227	39	179	\N	180	\N
856	224	39	65	\N	260	\N
857	228	39	182	\N	320	\N
858	229	39	125	\N	300	\N
859	230	39	200	\N	240	\N
860	231	39	125	\N	300	\N
866	232	39	125	\N	300	\N
867	233	39	182	\N	320	\N
868	234	39	65	\N	260	\N
869	235	39	179	\N	180	\N
870	236	39	105	\N	250	\N
871	237	39	182	\N	320	\N
872	238	39	65	\N	260	\N
873	239	39	200	\N	240	\N
874	240	39	182	\N	320	\N
875	241	39	125	\N	300	\N
877	242	24	117	\N	450.0	\N
878	242	25	80	\N	179.0	\N
881	243	24	84	\N	330.0	\N
882	243	25	135	\N	178.0	\N
885	244	24	192	\N	320.0	\N
886	244	25	174	\N	175.0	\N
889	245	24	112	\N	370.0	\N
890	245	25	142	\N	165.0	\N
893	246	24	150	\N	365.0	\N
894	246	25	104	\N	168.0	\N
897	247	24	124	\N	400.0	\N
898	247	25	121	\N	185.0	\N
901	248	24	176	\N	415.0	\N
902	248	25	142	\N	165.0	\N
905	249	24	152	\N	349.0	\N
906	249	25	174	\N	175.0	\N
909	250	24	168	\N	410.0	\N
910	250	25	80	\N	179.0	\N
913	251	24	180	\N	380.0	\N
914	251	25	121	\N	185.0	\N
917	252	24	180	\N	380.0	\N
918	252	25	120	\N	166.0	\N
921	253	24	112	\N	370.0	\N
922	253	25	123	\N	163.0	\N
925	254	24	154	\N	430.0	\N
926	254	25	172	\N	180.0	\N
929	255	24	168	\N	410.0	\N
930	255	25	121	\N	185.0	\N
933	256	24	168	\N	410.0	\N
934	256	25	172	\N	180.0	\N
937	257	24	180	\N	380.0	\N
938	257	25	172	\N	180.0	\N
941	258	24	192	\N	320.0	\N
942	258	25	174	\N	175.0	\N
945	259	24	157	\N	369.0	\N
946	259	25	116	\N	190.0	\N
949	260	24	69	\N	310.0	\N
950	260	25	88	\N	159.0	\N
953	261	24	68	\N	315.0	\N
954	261	25	76	\N	161.0	\N
957	262	24	124	\N	400.0	\N
958	262	25	123	\N	163.0	\N
961	263	24	143	\N	425.0	\N
962	263	25	199	\N	170.0	\N
965	264	24	60	\N	305.0	\N
966	264	25	172	\N	180.0	\N
969	265	24	143	\N	425.0	\N
970	265	25	199	\N	170.0	\N
973	266	24	60	\N	305.0	\N
974	266	25	172	\N	180.0	\N
977	267	24	112	\N	370.0	\N
978	267	25	85	\N	162.0	\N
985	269	24	143	\N	425.0	\N
986	269	25	199	\N	170.0	\N
989	270	24	101	\N	459.0	\N
990	270	25	142	\N	165.0	\N
993	271	24	124	\N	400.0	\N
994	271	25	121	\N	185.0	\N
997	272	24	79	\N	368.0	\N
998	272	25	135	\N	178.0	\N
\.


--
-- TOC entry 5872 (class 0 OID 34270)
-- Dependencies: 283
-- Data for Name: products; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.products (id, category_id, brand_id, name, base_price, promo_price, stock_quantity, power_draw_w, image_url) FROM stdin;
24	5	21	Crucial 2TB M.2 PCIe Gen5 NVMe P510	1099.00	899.00	13	0	products/storage/crucial_PCIe5.jpg
25	5	21	Crucial 1TB M.2 PCIe Gen5 NVMe P510	699.00	569.00	24	0	products/storage/crucial_PCIe5.jpg
23	4	35	Patriot 32GB (2x16GB) 6000MT/s CL30 Venom	1599.00	\N	3	0	products/ram/Patriot_32GB_(2x16GB)_6000MTs_CL30_Venom.jpg
26	1	2	Intel Core Ultra 5 245KF	749.99	650.00	10	125	products/cpu/Intel_Core_Ultra_5_245KF.jpg
27	1	2	Intel Core Ultra 5 225F	685.00	\N	10	65	products/cpu/Intel_Core_Ultra_5_225F.jpg
29	1	1	AMD Ryzen 5 7600X	760.00	\N	13	105	products/cpu/AMD_Ryzen_5_7600X.jpg
30	1	1	AMD Ryzen 5 7600	730.00	630.00	13	65	products/cpu/AMD_Ryzen_5_7600X.jpg
28	4	27	GOODRAM 32GB (2x16GB) 6400MHz CL32 IRDM BLACK V SILVER	1649.00	\N	4	0	products/ram/GOODRAM_32GB_(2x16GB)_6400MHz_CL32_IRDM_BLACK_V_SILVER.jpg
31	4	18	Kingston FURY 16GB (2x8GB) 3200MHz CL16 Beast Black	699.00	\N	8	0	products/ram/Kingston_FURY_16GB_(2x8GB)_3200MHz_CL16_Beast_Black.jpg
32	4	27	GOODRAM 32GB (2x16GB) 6000MHz CL30 IRDM BLACK V SILVER	1799.00	1645.00	3	0	products/ram/GOODRAM_32GB_(2x16GB)_6000MHz_CL30_IRDM_BLACK_V_SILVER.jpg
33	4	18	Kingston FURY 32GB (2x16GB) 5600MHz CL36 Beast Black EXPO AMD	1849.00	\N	2	0	products/ram/Kingston_FURY_32GB_(2x16GB)_5600MHz_CL36_Beast_Black_EXPO_AMD.jpg
34	4	35	Patriot 32GB (2x16GB) 6000MHz CL36 VIPER VENOM	1769.00	\N	4	0	products/ram/Patriot_32GB_(2x16GB)_6000MHz_CL36_VIPER_VENOM.jpg
35	1	1	AMD Ryzen 7 7800X3D Tray	1230.00	1100.00	13	65	products/cpu/AMD_Ryzen_7_7800X3D_Tray.jpg
36	4	18	Kingston FURY 32GB (2x16GB) 6000MT/s CL30 Beast Black EXPO	1859.00	1719.00	4	0	products/ram/Kingston_FURY_32GB_(2x16GB)_6000MTs_CL30_Beast_Black_EXPO.jpg
37	2	6	Gigabyte Radeon RX 9060 XT Gaming OC 16GB GDDR6	2099.00	1839.00	15	150	products/gpu/Gigabyte_Radeon_RX_9060_XT_Gaming_OC_16GB_GDDR6.jpg
38	1	1	AMD Ryzen 7 9800X3D	1959.00	1849.00	7	120	products/cpu/AMD_Ryzen 7_9800X3D.jpg
1	1	1	AMD Ryzen 5 5600	580.00	\N	5	65	products/cpu/Ryzen5_5600.jpg
2	1	1	AMD Ryzen 5 5500	299.00	\N	5	65	products/cpu/Ryzen5_5600.jpg
3	1	1	AMD Ryzen 5 5600XT	609.00	\N	5	65	products/cpu/Ryzen5_5600.jpg
5	1	1	AMD Ryzen 7 5800X	830.00	\N	5	105	products/cpu/Ryzen7_5800X.jpg
4	1	1	AMD Ryzen 7 5700X	780.00	\N	5	65	products/cpu/Ryzen7_5800X.jpg
53	2	2	Intel Arc Pro B50 16GB GDDR6	1799.00	\N	10	135	products/gpu/Intel_Arc_Pro_B50_16GB_GDDR6.jpg
48	2	5	MSI GeForce RTX 5070 Ti Gaming Trio OC 16GB GDDR7	4800.00	\N	10	130	products/gpu/MSI_GeForce_RTX_5070_Ti_Gaming_Trio_OC_16GB_GDDR7.jpg
39	4	20	G.SKILL 32GB (2x16GB) 3200MHz CL16 Aegis	1199.00	\N	5	0	products/ram/G.SKILL_32GB_(2x16GB)_3200MHz_CL16_Aegis.jpg
40	4	22	Lexar 32GB (2x16GB) 6000 CL30 Ares RGB	1859.00	\N	3	0	products/ram/Lexar_32GB_(2x16GB)_6000_CL30_Ares_RGB.jpg
16	5	27	GOODRAM 512GB M.2 PCIe NVMe PX500 G3	449.00	\N	5	0	GOODRAM_512GB_M.2.jpg
17	5	22	Lexar 4TB M.2 PCIe Gen5 NVMe NM990	2399.00	\N	4	0	products/storage/lexar_m.2_gen5.jpg
18	5	22	Lexar 2TB M.2 PCIe Gen5 NVMe NM990	1299.00	\N	11	0	products/storage/lexar_m.2_gen5.jpg
19	5	22	Lexar 1TB M.2 PCIe Gen5 NVMe NM990	839.00	\N	19	0	products/storage/lexar_m.2_gen5.jpg
20	5	18	Kingston 4TB M.2 PCIe Gen5 NVMe Fury Renegade G5	2799.00	\N	5	0	products/storage/kingston_fury_PCIe5.jpg
21	5	18	Kingston 2TB M.2 PCIe Gen5 NVMe Fury Renegade G5	1599.00	\N	10	0	products/storage/kingston_fury_PCIe5.jpg
22	5	18	Kingston 1TB M.2 PCIe Gen5 NVMe Fury Renegade G5	1049.00	\N	14	0	products/storage/kingston_fury_PCIe5.jpg
41	1	2	Intel Core i7-14700KF	1460.00	\N	5	125	products/cpu/IntelCorei7-14700KF.jpg
42	4	27	GOODRAM 32GB (2x16GB) 6000 CL36 IRDM BLACK V SILVER	1675.00	\N	4	0	products/ram/GOODRAM_32GB_(2x16GB)_6000_CL36_IRDM_BLACK_V_SILVER.jpg
43	4	18	Kingston FURY 32GB (2x16GB) 3200MHz CL16 Beast Black	1149.00	1099.00	5	0	products/ram/Kingston_FURY_32GB_(2x16GB)_3200MHz_CL16_Beast_Black.jpg
49	2	5	Gigabyte GeForce RTX 5080 Windforce OC 16GB GDDR7 DLSS4	5999.00	\N	10	135	products/gpu/Gigabyte_GeForce_RTX_5080_Windforce_OC_16GB_GDDR7_DLSS4.jpg
50	2	4	ASUS GeForce RTX 5080 Prime OC 16GB GDDR7 DLSS4	6499.00	\N	10	145	products/gpu/Gigabyte_GeForce_RTX_5080_Windforce_OC_16GB_GDDR7_DLSS4.jpg
14	2	14	Karta graficzna ASRock RX 6700 XT Challenger D 12 GB	1600.00	\N	3	230	products/gpu/RX6700_XT.jpg
15	2	14	ASRock Radeon RX 6600 Challenger D 8GB GDDR6	1000.00	\N	4	130	products/gpu/RX_6600.jpg
44	2	5	MSI GeForce RTX 5060 Ventus 2X OC 8GB GDDR7 DLSS4	1399.00	1000.00	20	145	products/gpu/MSI_GeForce_RTX_5060_Ventus_2X_OC_8GB_GDDR7_DLSS4.jpg
46	2	6	Gigabyte Radeon RX 9070 XT Gaming OC 16GB GDDR6	3199.00	\N	8	125	products/gpu/Zotac_GeForce_RTX_5070_Ti_Solid_SFF_16GB_GDDR7_DLSS4.jpg
47	2	6	ASUS GeForce RTX 5070 Dual OC 12GB GDDR7 DLSS4	2899.00	\N	14	115	products/gpu/ASUS_GeForce_RTX_5070_Dual_OC_12GB_GDDR7_DLSS4.jpg
51	2	13	INNO3D GeForce RTX 5080 X3 OC 16GB GDDR7 DLSS4	5999.00	\N	10	145	products/gpu/INNO3D_GeForce_RTX_5080_X3_OC_16GB_GDDR7_DLSS4.jpg
54	2	9	Sapphire Radeon RX 9060 XT Pure OC 16GB GDDR6	2299.00	\N	10	155	products/gpu/Sapphire_Radeon_RX_9060_XT_Pure_OC_16GB_GDDR6.jpg
55	2	4	ASUS GeForce RTX 5070 Ti Prime OC 16GB GDDR7 DLSS4	5299.00	\N	10	165	products/gpu/ASUS_GeForce_RTX_5070_Ti_Prime_OC_16GB_GDDR7_DLSS4.jpg
56	2	13	INNO3D GeForce RTX 5060 Ti Twin X2 OC 16GB GDDR7 DLSS4	2499.00	\N	10	135	products/gpu/INNO3D_GeForce_RTX_5060_Ti_Twin_X2_OC_16GB_GDDR7_DLSS4.jpg
57	2	9	Sapphire Radeon RX 9060 XT Pulse OC 8GB GDDR6	2039.00	\N	10	115	products/gpu/Sapphire_Radeon_RX_9060_XT_Pulse_OC_8GB_GDDR6.jpg
58	2	14	ASRock Radeon AI PRO R9700 Creator 32GB GDDR6	7819.00	\N	10	125	products/gpu/ASRock_Radeon_AI_PRO_R9700_Creator_32GB_GDDR6.jpg
60	2	4	ASUS Radeon RX 9070 XT Prime OC White 16GB GDDR6	3500.00	\N	10	125	products/gpu/ASUS_Radeon_RX_9070_XT_Prime_OC_White_16GB_GDDR6.jpg
61	2	10	PowerColor Radeon RX 7600 Fighter 8GB V2 GDDR6	1000.00	\N	10	125	products/gpu/PowerColor_Radeon_RX_7600_Fighter_8GB_V2_GDDR6.jpg
63	2	4	ASUS Radeon RX 9070 Prime EVO OC 16GB GDDR6	3000.00	\N	10	145	products/gpu/ASUS_Radeon_RX_9070_Prime_EVO_OC_16GB_GDDR6.jpg
64	2	6	Gigabyte GeForce RTX 5050 D6 8GB GDDR6 DLSS4	1300.00	\N	10	135	products/gpu/Gigabyte_GeForce_RTX_5050_D6_8GB_GDDR6_DLSS4.jpg
66	2	4	ASUS GeForce RTX 5070 Ti ROG Strix OC 16GB GDDR7 DLSS4	5500.00	\N	10	145	products/gpu/ASUS_GeForce_RTX_5070_Ti_ROG_Strix_OC_16GB_GDDR7_DLSS4.jpg
67	2	4	Zotac GeForce RTX 5080 AMP Extreme Infinity 16GB GDDR7 DLSS4	6300.00	\N	10	145	products/gpu/Zotac_GeForce_RTX_5080_AMP_Extreme_Infinity_16GB_GDDR7_DLSS4.jpg
68	2	7	Palit GeForce RTX 5070 Infinity 3 12GB GDDR7 DLSS4	2900.00	\N	10	145	products/gpu/Palit_GeForce_RTX_5070_Infinity_3_12GB_GDDR7_DLSS4.jpg
69	2	6	Gigabyte GeForce RTX 5060 Aero OC 8GB GDDR7 DLSS4	1800.00	\N	10	145	products/gpu/Gigabyte_GeForce_RTX_5060_Aero_OC_8GB_GDDR7_DLSS4.jpg
71	4	18	Kingston FURY 32GB (2x16GB) 6000MTs CL30 Beast Black RGB	2073.00	\N	2	0	products/ram/Kingston_FURY_32GB_(2x16GB)_6000MTs_CL30_Beast_Black_RGB.jpg
72	4	23	ADATA 32GB (2x16GB) 6000MHz CL30 Lancer Blade	1963.00	\N	3	0	products/ram/ADATA_32GB_(2x16GB)_6000MHz_CL30_Lancer_Blade.jpg
74	4	18	Kingston FURY 16GB (2x8GB) 5600MHz CL36 Beast Black EXPO	1259.00	\N	5	0	products/ram/Kingston_FURY_16GB_(2x8GB)_5600MHz_CL36_Beast_Black_EXPO.jpg
75	4	27	GOODRAM 64GB (2x32GB) 6000MHz CL30 IRDM BLACK V SILVER	2558.00	2519.00	2	0	products/ram/GOODRAM_64GB_(2x32GB)_6000MHz_CL30_IRDM_BLACK_V_SILVER.jpg
76	4	27	GOODRAM 32GB (2x16GB) 3600MHz CL18 IRDM PRO Deep Black	1099.00	959.00	8	0	products/ram/GOODRAM_32GB_(2x16GB)_3600MHz_CL18_IRDM_PRO_Deep_Black.jpg
77	4	35	Patriot 32GB (2x16GB) 6000MHz CL36 VIPER VENOM RGB	1999.00	\N	4	0	products/ram/Patriot_32GB_(2x16GB)_6000MHz_CL36_VIPER_VENOM_RGB.jpg
78	4	21	Crucial 32GB (2x16GB) 6000MHz CL36 Pro Overclocking	1999.00	\N	5	0	products/ram/Crucial_32GB_(2x16GB)_6000MHz_CL36_Pro_Overclocking.jpg
80	4	35	Patriot 32GB(2x16GB) 6000MTs CL30 Venom RGB	1870.00	\N	6	0	products/ram/Patriot_32GB(2x16GB)_6000MTs_CL30_Venom_RGB.jpg
81	14	36	iiyama G-Master GCB3486WQSCP-B1 Gold Phoenix	1700.00	\N	12	45	products/monitor/iiyama_G-Master_GCB3486WQSCP-B1_Gold_Phoenix.jpg
82	4	18	Kingston FURY 64GB (2x32GB) 6000MTs CL30 Beast Black RGB	3699.00	\N	1	0	products/ram/Kingston_FURY_64GB_(2x32GB)_6000MTs_CL30_Beast_Black_RGB.jpg
83	4	18	Kingston FURY 32GB (2x16GB) 3200MHz CL20 Impact	1019.00	\N	7	0	products/ram/Kingston_FURY_32GB_(2x16GB)_3200MHz_CL20_Impact.jpg
84	4	18	Kingston FURY 16GB (2x8GB) 3600MHz CL16 Renegade Black	709.00	699.00	11	0	products/ram/Kingston_FURY_16GB_(2x8GB)_3600MHz_CL16_Renegade_Black.jpg
85	4	18	Kingston FURY 32GB (2x16GB) 3600MHz CL16 Renegade Black	1329.00	\N	4	0	products/ram/Kingston_FURY_32GB_(2x16GB)_3600MHz_CL16_Renegade_Black.jpg
86	4	18	Kingston FURY 32GB (2x16GB) 6000 CL36 FURY Beast White	2019.00	\N	2	0	products/ram/Kingston_FURY_32GB_(2x16GB)_6000_CL36_FURY_Beast_White.jpg
45	2	5	Zotac GeForce RTX 5070 Ti Solid SFF 16GB GDDR7 DLSS4	4249.00	\N	12	135	products/gpu/Zotac_GeForce_RTX_5070_Ti_Solid_SFF_16GB_GDDR7_DLSS4.jpg
52	2	5	Zotac GeForce RTX 5060 Twin Edge OC White 8GB GDDR7 DLSS4	1599.00	\N	10	135	products/gpu/Zotac_GeForce_RTX_5060_Twin_Edge_OC_White_8GB_GDDR7_DLSS4.jpg
59	2	5	Zotac GeForce RTX 5090 ArcticStorm AIO 32GB GDDR7 DLSS4	18999.00	\N	10	125	products/gpu/Zotac_GeForce_RTX_5090_ArcticStorm_AIO_32GB_GDDR7_DLSS4.jpg
62	2	5	Zotac GeForce RTX 5050 Low Profile 8GB GDDR6 DLSS4	1250.00	\N	10	125	products/gpu/Zotac_GeForce_RTX_5050_Low_Profile_8GB_GDDR6_DLSS4.jpg
65	2	5	Zotac GeForce RTX 5060 Ti Twin Edge OC White 16GB GDDR7 DLSS4	2500.00	\N	10	135	products/gpu/Zotac_GeForce_RTX_5060_Ti_Twin_Edge_OC_White_16GB_GDDR7_DLSS4.jpg
70	2	5	Zotac GeForce RTX 5050 Twin Edge OC 8GB GDDR6 DLSS4	1400.00	\N	10	145	products/gpu/Zotac_GeForce_RTX_5050_Twin_Edge_OC_8GB_GDDR6_DLSS4.jpg
73	14	5	MSI MPG 321URX QD-OLED	2700.00	\N	12	45	products/monitor/MSI_MPG_321URX_QD-OLED.jpg
87	4	19	Corsair 32GB (2x16GB) 6000 CL36 Vengeance RGB AMD EXPO	2129.00	\N	3	0	products/ram/Corsair_32GB_(2x16GB)_6000_CL36_Vengeance_RGB_AMD_EXPO.jpg
88	4	21	Crucial 16GB (1x16GB) 5600MHz CL46	999.00	\N	6	0	products/ram/Crucial_16GB_(1x16GB)_5600MHz_CL46.jpg
89	4	18	Kingston FURY 16GB (2x8GB) 3600MHz CL17 Beast Black	799.00	\N	15	0	products/ram/Kingston_FURY_16GB_(2x8GB)_3600MHz_CL17_Beast_Black.jpg
90	4	27	GOODRAM 32GB (2x16GB) 5600 CL36 IRDM	1669.00	\N	7	0	products/ram/GOODRAM_32GB_(2x16GB)_5600_CL36_IRDM.jpg
91	4	18	Kingston FURY 32GB (2x16GB) 6000MHz CL36 Beast Black	2169.00	\N	4	0	products/ram/Kingston_FURY_32GB_(2x16GB)_6000MHz_CL36_Beast_Black.jpg
92	14	37	Acer SA242YH1	270.00	\N	12	45	products/monitor/Acer_SA242YH1.jpg
93	4	35	Patriot 64GB (2x32GB) 6000MTs CL30 Venom	2999.00	2579.00	4	0	products/ram/Patriot_64GB_(2x32GB)_6000MTs_CL30_Venom.jpg
94	14	17	Samsung Odyssey  G5 S27FG502EUX G50F	600.00	\N	10	21	products/monitor/Samsung_Odyssey__G5_S27FG502EUX_G50F.jpg
95	14	38	Dell Alienware AW2725DM	900.00	800.00	12	21	products/monitor/Dell_Alienware_AW2725DM.jpg
96	14	6	Gigabyte G25F2A	480.00	\N	11	21	products/monitor/Gigabyte_G25F2A.jpg
97	14	6	Gigabyte G25F2A	480.00	\N	11	21	products/monitor/Gigabyte_G25F2A.jpg
98	14	6	MSI MPG 321URXW QD-OLED	3000.00	\N	4	44	products/monitor/MSI_MPG_321URXW_QD-OLED.jpg
99	14	6	MSI MPG 321URXW QD-OLED	3000.00	\N	4	44	products/monitor/MSI_MPG_321URXW_QD-OLED.jpg
100	14	17	Samsung Odyssey  G5 S27FG500SUX G50SF	1549.00	\N	13	28	products/monitor/Samsung_Odyssey__G5_S27FG500SUX_G50SF.jpg
101	14	39	Lenovo Legion 24-10	469.00	\N	3	34	products/monitor/Lenovo_Legion_24-10.jpg
102	14	36	iiyama G-Master GB2771QSU-B1 Red Eagle	800.00	\N	9	34	products/monitor/iiyama_G-Master_GB2771QSU-B1_Red_Eagle.jpg
103	14	37	Acer Predator X27UW3bmiiprx	1600.00	\N	19	25	products/monitor/Acer_Predator_X27UW3bmiiprx.jpg
104	14	4	ASUS ROG Strix OLED XG27AQDMGR	2140.00	\N	16	25	products/monitor/ASUS_ROG_Strix_OLED_XG27AQDMGR.jpg
105	14	39	Lenovo Legion 25-10	550.00	\N	6	18	products/monitor/Lenovo_Legion_25-10.jpg
106	14	5	MSI PRO MP242L	290.00	\N	6	14	products/monitor/MSI_PRO_MP242L.jpg
107	14	40	Dell P2425H	600.00	\N	10	12	products/monitor/Dell_P2425H.jpg
108	14	41	KOORUI G2722P IPS 200 Hz 1ms	700.00	\N	10	12	products/monitor/KOORUI_G2722P_IPS_200_Hz_1ms.jpg
109	6	6	Gigabyte UD850GM PG5 V2 850W 80 Plus Gold ATX 3.1	299.00	289.00	20	0	products/psu/Gigabyte_UD850GM_PG5_V2_850W_80_Plus_Gold_ATX_3.1.jpg
110	14	42	Xiaomi Curved Gaming Monitor G34WQi	1100.00	900.00	20	31	products/monitor/Xiaomi_Curved_Gaming_Monitor_G34WQi.jpg
111	14	36	iiyama G-Master GB2771UHSU-B1 Red Eagle	1300.00	\N	2	26	products/monitor/iiyama_G-Master_GB2771UHSU-B1_Red_Eagle.jpg
112	6	29	be quiet! Pure Power 13 M 850W 80 Plus Gold	599.00	\N	10	0	products/psu/be_quiet!_Pure_Power_13_M_850W_80_Plus_Gold.jpg
113	6	29	be quiet! Power Zone 2 1000W 80 PLUS Platinum	799.00	\N	8	0	products/psu/be_quiet!_Power_Zone_2_1000W_80_PLUS_Platinum.jpg
114	13	4	ASUS PCE-AXE5400 (5400Mb/s a/b/g/n/ac/ax) BT 5.2	139.00	\N	11	2	products/network/ASUS_PCE-AXE5400_(5400Mb_s_a_b_g_n_ac_ax)_BT_5.2.jpg
115	6	28	ENDORFY Supremo FM6 1000W 80 Plus Gold ATX 3.1	649.00	\N	9	0	products/psu/ENDORFY_Supremo_FM6_1000W_80_Plus_Gold_ATX_3.1.jpg
116	6	6	Gigabyte UD750GM PG5 V2 750W 80 Plus Gold ATX 3.1	359.00	\N	15	0	products/psu/Gigabyte_UD750GM_PG5_V2_750W_80_Plus_Gold_ATX_3.1.jpg
117	6	29	be quiet! System Power 11 750W 80 Plus Bronze	349.00	\N	16	0	products/psu/be_quiet!_System_Power_11_750W_80_Plus_Bronze.jpg
119	6	28	ENDORFY Supremo FM6 750W 80 Plus Gold ATX 3.1	449.00	\N	13	0	products/psu/ENDORFY_Supremo_FM6_750W_80_Plus_Gold_ATX_3.1.jpg
120	6	29	be quiet! Dark Power 14 850W 80 Plus Titanium ATX 3.1	899.00	\N	7	0	products/psu/be_quiet!_Dark_Power_14_850W_80_Plus_Titanium_ATX_3.1.jpg
121	6	5	MSI MAG 650W 80 Plus Bronze	249.00	\N	17	0	products/psu/MSI_MAG_650W_80_Plus_Bronze.jpg
122	6	5	MSI MPG A850G PCIe5.0 850W 80 Plus Gold ATX 3.1	529.00	\N	12	0	products/psu/MSI_MPG_A850G_PCIe5.0_850W_80_Plus_Gold_ATX_3.1.jpg
123	13	44	Cudy PE10 (10/100/1000Mbit)	30.00	\N	21	2	products/network/Cudy_PE10_(10_100_1000Mbit).jpg
124	6	5	MSI MAG 550W 80 Plus Bronze	199.00	\N	25	0	products/psu/MSI_MAG_550W_80_Plus_Bronze.jpg
125	6	29	be quiet! Pure Power 13 M 750W 80 Plus Gold	499.00	\N	14	0	products/psu/be_quiet!_Pure_Power_13_M_750W_80_Plus_Gold.jpg
126	13	4	ASUS ROG USB-BE92 (6500Mb/s a/b/g/n/ac/ax/be)	440.00	\N	21	2	products/network/ASUS_ROG_USB-BE92_(6500Mb_s_a_b_g_n_ac_ax_be).jpg
127	6	28	ENDORFY Supremo FM6 850W 80 Plus Gold ATX 3.1	549.00	\N	11	0	products/psu/ENDORFY_Supremo_FM6_850W_80_Plus_Gold_ATX_3.1.jpg
129	6	28	ENDORFY Vero L5 600W 80 Plus Bronze	249.00	\N	15	0	products/psu/ENDORFY_Vero_L5_600W_80_Plus_Bronze.jpg
130	6	29	be quiet! System Power 11 550W 80 Plus Bronze	249.00	\N	16	0	products/psu/be_quiet!_System_Power_11_550W_80_Plus_Bronze.jpg
131	6	29	be quiet! Dark Power 14 1000W 80 Plus Titanium ATX 3.1	1119.00	\N	4	0	products/psu/be_quiet!_Dark_Power_14_1000W_80_Plus_Titanium_ATX_3.1.jpg
132	6	19	Corsair HXi Shift 1000W 80 Plus Platinum	999.00	\N	5	0	products/psu/Corsair_HXi_Shift_1000W_80_Plus_Platinum.jpg
134	6	19	Corsair RM650e 650W 80 Plus Gold ATX 3.1	349.00	\N	17	0	products/psu/Corsair_RM650e_650W_80_Plus_Gold_ATX_3.1.jpg
136	6	29	be quiet! Dark Power 14 1200W 80 Plus Titanium ATX 3.1	1399.00	\N	3	0	products/psu/be_quiet!_Dark_Power_14_1200W_80_Plus_Titanium_ATX_3.1.jpg
139	6	34	Fractal Design Ion 3 Gold 1000W 80 Plus Gold	799.00	\N	7	0	products/psu/Fractal_Design_Ion_3_Gold_1000W_80_Plus_Gold.jpg
141	6	34	Fractal Design Ion 3 Gold 850W 80 Plus Gold	599.00	\N	6	0	products/psu/Fractal_Design_Ion_3_Gold_850W_80_Plus_Gold.jpg
144	6	19	Corsair RM850e 850W 80 Plus Gold ATX 3.1	539.00	439.00	7	0	products/psu/Corsair_RM850e_850W_80_Plus_Gold_ATX_3.1.jpg
147	6	19	Corsair RM750e 750W 80 Plus Gold ATX 3.1	489.00	389.00	8	0	products/psu/Corsair_RM750e_750W_80_Plus_Gold_ATX_3.1.jpg
128	13	43	TP-Link Archer TBE550E (9300Mb/s a/b/g/n/ac/ax/be) BT 5.4	150.00	100.00	21	2	products/network/TP-Link_Archer_TBE550E_(9300Mb_s_a_b_g_n_ac_ax_be)_BT_5.4.jpg
133	13	43	TP-Link TG-3468 (10/100/1000Mbit)	155.00	129.00	21	2	products/network/TP-Link_TG-3468_(10_100_1000Mbit).jpg
118	13	43	TP-Link Archer T3U Plus (1300Mb/s a/b/g/n/ac) DualBand	89.90	\N	11	2	products/network/TP-Link_Archer_T3U_Plus_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg
135	13	43	TP-Link Archer TX3000E (3000Mb/s a/b/g/n/ac/ax) BT 5.0	255.00	\N	21	2	products/network/TP-Link_Archer_TX3000E_(3000Mb_s_a_b_g_n_ac_ax)_BT_5.0.jpg
148	6	5	MSI MEG Ai1600T PCIE5 1600W 80 Plus Titanium	2999.00	\N	2	0	products/psu/MSI_MEG_Ai1600T_PCIE5_1600W_80_Plus_Titanium.jpg
160	13	43	TP-Link TL-WN881ND (802.11b/g/n 300Mb/s)	64.00	\N	21	2	products/network/TP-Link_TL-WN881ND_(802.11b_g_n_300Mb_s).jpg
161	13	43	TP-Link TL-WN821N (802.11b/g/n 300Mb/s)	44.00	\N	21	2	products/network/TP-Link_TL-WN821N_(802.11b_g_n_300Mb_s).jpg
162	13	43	TP-Link TL-WN822N (802.11b/g/n 300Mb/s)	59.00	\N	21	2	products/network/TP-Link_TL-WN822N_(802.11b_g_n_300Mb_s).jpg
163	6	33	Cooler Master MWE Bronze V3 650W 80 PLUS Bronze ATX 3.1	249.00	\N	14	0	products/psu/Cooler_Master_MWE_Bronze_V3_650W_80_PLUS_Bronze_ATX_3.1.jpg
164	1	1	AMD Ryzen 5 7500X3D	999.00	950.00	12	65	products/cpu/AMD_Ryzen_5_7500X3D.jpg
166	1	1	AMD Ryzen 9 9950X3D	2949.00	\N	7	170	products/cpu/AMD_Ryzen_9_9950X3D.jpg
165	1	1	AMD Ryzen 7 9700X	1366.00	1300.00	10	65	products/cpu/AMD_Ryzen_7_9700X.jpg
142	13	43	TP-Link Archer TXE75E (5400Mb/s a/b/g/n/ac/ax)	100.00	89.90	21	2	products/network/TP-Link_Archer_TXE75E_(5400Mb_s_a_b_g_n_ac_ax).jpg
167	1	1	AMD Ryzen 5 9600X	919.00	\N	12	65	products/cpu/AMD_Ryzen_5_9600X.jpg
168	1	1	AMD Ryzen 7 9850X3D	2149.00	\N	5	120	products/cpu/AMD_Ryzen_7_9850X3D.jpg
169	1	2	 Intel Core i9-14900K	2099.00	1750.00	5	125	products/cpu/Intel_Core_i9-14900K.jpg
149	6	6	Gigabyte Aorus Elite P 850W 80 Plus Platinum ATX 3.1	399.00	389.00	17	0	products/psu/Gigabyte_Aorus_Elite_P_850W_80_Plus_Platinum_ATX_3.1.jpg
170	1	2	 Intel Core i9-14900KF	1899.00	1600.00	5	125	products/cpu/Intel_Core_i9-14900KF.jpg
171	1	2	Intel Core i5-12400F	649.00	\N	12	65	products/cpu/Intel_Core_i5-12400F.jpg
172	1	2	Intel Core Ultra 7 265KF	1099.00	1050.00	12	125	products/cpu/Intel_Core_Ultra_7_265KF.jpg
140	13	43	TP-Link Archer TXE72E (5400Mb/s a/b/g/n/ac/ax) BT 5.3	134.00	\N	21	2	products/network/TP-Link_TX401_(100_1000Mbit_10Gbit).jpg
150	6	14	ASRock Challenger 550W 80 Plus Bronze	279.00	\N	18	0	products/psu/ASRock_Challenger_550W_80_Plus_Bronze.jpg
173	1	1	AMD Ryzen 5 8400F	589.00	\N	11	65	products/cpu/AMD_Ryzen_5_8400F.jpg
143	13	43	TP-Link Archer T3U Nano (1300Mb/s a/b/g/n/ac) DualBand	434.00	\N	21	2	products/network/TP-Link_Archer_T3U_Nano_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg
174	1	1	AMD Ryzen 5 8500G	599.00	\N	12	65	products/cpu/AMD_Ryzen_5_8500G.jpg
145	13	43	TP-Link Archer TX20E (1800Mb s a b g n ac ax) BT 5.2	334.00	200.00	21	2	products/network/TP-Link_Archer_T3U_Nano_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg
175	1	2	Intel Core i5-14400F Tray	669.00	640.00	12	65	products/cpu/Intel_Core_i5-14400F_Tray.jpg
146	13	43	TP-Link Archer TX20U (1800Mb/s a/b/g/n/ac/ax)	123.45	100.00	21	2	products/network/TP-Link_Archer_TX20U_(1800Mb_s_a_b_g_n_ac_ax).jpg
151	6	14	ASRock Challenger 650W 80 Plus Bronze	309.00	\N	9	0	products/psu/ASRock_Challenger_650W_80_Plus_Bronze.jpg
152	6	14	ASRock Challenger 750W 80 Plus Bronze	349.00	\N	11	0	products/psu/ASRock_Challenger_750W_80_Plus_Bronze.jpg
153	6	14	ASRock Challenger 850W 80 Plus Gold	449.00	\N	10	0	products/psu/ASRock_Challenger_850W_80_Plus_Gold.jpg
154	13	43	TP-Link Archer T3U (1300Mb/s a/b/g/n/ac) DualBand	69.01	\N	21	2	products/network/TP-Link_Archer_T3U_(1300Mb_s_a_b_g_n_ac)_DualBand.jpg
155	13	43	TP-Link Archer TXE70UH (5400Mb/s a/b/g/n/ac/ax)	219.00	\N	21	2	products/network/TP-Link_Archer_TXE70UH_(5400Mb_s_a_b_g_n_ac_ax).jpg
156	13	43	TP-Link Archer T2U Nano (600Mb/s a/b/g/n/ac) DualBand	49.00	\N	21	2	products/network/TP-Link_Archer_T2U_Nano_(600Mb_s_a_b_g_n_ac)_DualBand.jpg
157	13	43	TP-Link TL-WN781ND (802.11b/g/n 150Mb/s)	48.00	45.00	21	2	products/network/TP-Link_TL-WN781ND_(802.11b_g_n_150Mb_s).jpg
158	13	43	TP-Link Archer TBE400E (6500Mb/s a/b/g/n/ac/ax/be) BT 5.4	259.00	\N	21	2	products/network/TP-Link_Archer_TBE400E_(6500Mb_s_a_b_g_n_ac_ax_be)_BT_5.4.jpg
159	13	43	TP-Link TX201 (2,5Gb/s) Low Profle	93.00	\N	21	2	products/network/TP-Link_TX201_(2,5Gb_s)_Low_Profle.jpg
188	3	4	ASUS PRIME Z790-P WIFI	794.00	\N	11	0	products/motherboard/ASUS_PRIME_Z790-P_WIFI.jpg
176	1	2	Intel Core Ultra 5 225	729.00	\N	10	65	products/cpu/Intel_Core_Ultra_5_225F.jpg
177	1	2	Intel Core Ultra 5 250KF Plus	899.00	\N	14	125	products/cpu/Intel_Core_Ultra_5_250KF_Plus.jpg
178	1	2	Intel Core i5-14600KF	969.00	930.00	14	125	Intel_Core_i5-14600KF.jpg
179	1	2	Intel Core i5-12600KF	799.00	\N	12	125	products/cpu/Intel_Core_i5-12600KF.jpg
180	1	2	Intel Core i7-12700KF	1119.00	1070.00	10	125	products/cpu/Intel_Core_i7-12700KF.jpg
181	1	2	Intel Core Ultra 9 285	2511.00	2300.00	7	65	products/cpu/Intel_Core_Ultra_9_285.jpg
182	3	4	ASUS TUF GAMING B860-PLUS WIFI	760.99	\N	23	0	products/motherboard/ASUS_TUF_GAMING_B860-PLUS_WIFI.jpg
184	3	4	ASUS B850M MAX GAMING WIFI	869.00	790.00	15	0	products/motherboard/ASUS_B850M_MAX_GAMING_WIFI.jpg
185	3	4	ASUS PRIME B760M-A WIFI D4	519.99	\N	15	0	products/motherboard/ASUS_PRIME_B760M-A_WIFI_D4.jpg
183	3	4	ASUS TUF GAMING B850-PLUS WIFI	830.00	\N	21	0	products/motherboard/ASUS_TUF_GAMING_B850-PLUS_WIFI.jpg
186	3	4	ASUS PRIME B550M-A	339.00	\N	13	0	products/motherboard/ASUS_PRIME_B550M-A.jpg
187	3	4	ASUS TUF GAMING B650E-E WIFI	639.00	\N	13	0	products/motherboard/ASUS_TUF_GAMING_B650E-E_WIFI.jpg
189	3	6	Gigabyte B650 EAGLE AX	565.00	530.00	17	0	products/motherboard/Gigabyte_B650_EAGLE_AX.jpg
190	3	6	Gigabyte B550 GAMING X V2	396.00	\N	17	0	products/motherboard/Gigabyte_B550_GAMING_X_V2.jpg
191	3	6	Gigabyte B760M DS3H DDR4	387.00	\N	13	0	products/motherboard/Gigabyte_B760M_DS3H_DDR4.jpg
192	3	6	Gigabyte B650 GAMING X AX V2	616.00	580.00	11	0	products/motherboard/Gigabyte_B650_GAMING_X_AX_V2.jpg
193	3	6	Gigabyte B650M S2H	395.00	\N	9	0	products/motherboard/Gigabyte_B650M_S2H.jpg
194	3	6	Gigabyte B760M DS3H WF6E GEN5	599.00	\N	9	0	products/motherboard/Gigabyte_B760M_DS3H_WF6E_GEN5.jpg
195	3	6	Gigabyte B860M A ELT WF6E ICE	589.00	\N	12	0	products/motherboard/Gigabyte_B860M_A_ELT_WF6E_ICE.jpg
196	3	6	Gigabyte B850 EAGLE WIFI6E	739.00	700.00	12	0	products/motherboard/Gigabyte_B850_EAGLE_WIFI6E.jpg
197	3	6	Gigabyte B550 EAGLE	399.00	\N	18	0	products/motherboard/Gigabyte_B550_EAGLE.jpg
198	3	14	ASRock B760M-HDV/M.2 D4	324.00	\N	15	0	products/motherboard/ASRock_B760M-HDV_M.2_D4.jpg
199	3	14	ASRock Z790 Pro RS	809.00	\N	12	0	products/motherboard/ASRock_Z790_Pro_RS.jpg
200	3	14	ASRock Z790 Steel Legend WiFi	999.00	\N	12	0	products/motherboard/ASRock_Z790_Steel_Legend_WiFi.jpg
201	3	14	ASRock B550M-HDV	288.00	\N	12	0	products/motherboard/ASRock_B550M-HDV.jpg
202	3	14	ASRock B550M PRO4	410.00	\N	12	0	products/motherboard/ASRock_B550M_PRO4.jpg
203	3	14	ASRock B860M-H2	399.00	\N	12	0	products/motherboard/ASRock_B860M-H2.jpg
204	3	14	ASRock B860 Pro-A WiFi	599.00	\N	16	0	products/motherboard/ASRock_B860_Pro-A_WiFi.jpg
205	3	14	ASRock B860 LiveMixer WiFi	799.00	750.00	12	0	products/motherboard/ASRock_B860_LiveMixer_WiFi.jpg
206	3	5	MSI MAG B860 TOMAHAWK WIFI	899.00	\N	11	0	products/motherboard/MSI_MAG_B860_TOMAHAWK_WIFI.jpg
207	3	5	MSI B860 GAMING PLUS WIFI	795.00	\N	11	0	products/motherboard/MSI_B860_GAMING_PLUS_WIFI.jpg
208	3	5	MSI MAG B850M MORTAR WIFI	939.00	\N	11	0	products/motherboard/MSI_MAG_B850M_MORTAR_WIFI.jpg
209	3	5	MSI PRO B850M-P WIFI	599.00	550.00	11	0	products/motherboard/MSI_PRO_B850M-P_WIFI.jpg
210	3	5	MSI Z790 GAMING PLUS WIFI	829.00	800.00	17	0	products/motherboard/MSI_Z790_GAMING_PLUS_WIFI.jpg
211	3	5	MSI MPG B550 GAMING PLUS	500.00	\N	17	0	products/motherboard/MSI_MPG_B550_GAMING_PLUS.jpg
212	12	28	ENDORFY Navis F240 ARGB	319.00	\N	7	0	products/cooler/ENDORFY_Navis_F240_ARGB.jpg
213	12	28	ENDORFY Fortis 5 ARGB	250.00	229.00	11	0	products/cooler/ENDORFY_Fortis_5_ARGB.jpg
214	12	28	ENDORFY Fera 5	129.00	\N	11	0	products/cooler/ENDORFY_Fera_5.jpg
215	12	28	ENDORFY Navis F360 ARGB	399.00	\N	13	0	products/cooler/ENDORFY_Navis_F360_ARGB.jpg
216	12	28	ENDORFY Navis F240	279.00	\N	9	0	products/cooler/ENDORFY_Navis_F240.jpg
217	12	45	Thermalright Peerless Vision 360 UB Argb White	599.00	\N	13	0	products/cooler/Thermalright_Peerless_Vision_360_UB_Argb_White.jpg
218	12	45	Thermalright Phantom Spirit 120 SE ARGB	199.90	\N	13	0	products/cooler/Thermalright_Phantom_Spirit_120_SE_ARGB.jpg
219	12	45	Thermalright Assassin X 120 Refined SE ARGB	99.00	\N	13	0	products/cooler/Thermalright_Assassin_X_120_Refined_SE_ARGB.jpg
220	12	45	Thermalright Aqua Elite 360 Black Argb V3	370.00	\N	13	0	products/cooler/Thermalright_Aqua_Elite_360_Black_Argb_V3.jpg
221	12	45	Thermalright Peerless Vision 240 Argb Black	439.00	\N	11	0	products/cooler/Thermalright_Peerless_Vision_240_Argb_Black.jpg
222	12	29	be quiet! Dark Rock 5	329.00	\N	9	0	products/cooler/be_quiet!_Dark_Rock_5.jpg
223	12	29	be quiet! Pure Rock Pro 3 LX, czarny	259.00	\N	13	0	products/cooler/be_quiet!_Pure_Rock_Pro_3_LX,_czarny.jpg
224	12	4	ASUS ROG STRIX LC III 240 ARGB	859.00	\N	4	0	products/cooler/ASUS_ROG_STRIX_LC_III_240_ARGB.jpg
225	12	29	be quiet! Light Loop 360mm	649.00	\N	13	0	products/cooler/be_quiet!_Light_Loop_360mm.jpg
226	12	29	be quiet! Light Loop 240mm	539.00	\N	13	0	products/cooler/be_quiet!_Light_Loop_240mm.jpg
227	12	29	be quiet! Pure Rock 3 LX, czarny	154.99	\N	13	0	products/cooler/be_quiet!_Pure_Rock_3_LX,_czarny.jpg
228	12	4	ASUS ROG RYUO IV SLC 360 ARGB	1799.00	\N	6	0	products/cooler/ASUS_ROG_RYUO_IV_SLC_360_ARGB.jpg
229	12	46	Krux HydroGlance 360 ARGB LCD	549.00	\N	6	0	products/cooler/Krux_HydroGlance_360_ARGB_LCD.jpg
230	12	47	Genesis Hydria 240 ARGB czarne	287.00	\N	6	0	products/cooler/Genesis_Hydria_240_ARGB_czarne.jpg
231	12	47	Genesis Hydria 360 ARGB czarne	368.00	350.00	6	0	products/cooler/Genesis_Hydria_360_ARGB_czarne.jpg
232	12	47	Genesis Hydria 360 czarne	315.00	\N	6	0	products/cooler/Genesis_Hydria_360_czarne.jpg
233	12	33	Cooler Master MasterLiquid 360 Core II ARGB	339.00	\N	12	0	products/cooler/Cooler_Master_MasterLiquid_360_Core_II_ARGB.jpg
234	12	33	Cooler Master MasterLiquid 240 Core II ARGB white	249.00	\N	12	0	products/cooler/Cooler_Master_MasterLiquid_240_Core_II_ARGB_white.jpg
235	12	48	Savio Vortex X2 ARGB	109.90	\N	12	0	products/cooler/Savio_Vortex_X2_ARGB.jpg
236	12	48	Noctua NH-D15 chromax.black	519.00	\N	12	0	products/cooler/Noctua_NH-D15_chromax.black.jpg
237	12	5	MSI MAG CORELIQUID A13 360	379.00	\N	12	0	products/cooler/MSI_MAG_CORELIQUID_A13_360.jpg
238	12	5	MSI MAG CORELIQUID A13 240	289.00	\N	12	0	products/cooler/MSI_MAG_CORELIQUID_A13_240.jpg
239	12	5	MSI MAG CORELIQUID E240 WHITE	289.00	\N	12	0	products/cooler/MSI_MAG_CORELIQUID_E240_WHITE.jpg
240	12	16	NZXT Kraken Plus 360 RGB LCD czarne	919.00	\N	9	0	products/cooler/NZXT_Kraken_Plus_360_RGB_LCD_czarne.jpg
241	12	16	NZXT Kraken Elite 280 RGB V2 LCD białe	829.00	\N	9	0	products/cooler/NZXT_Kraken_Elite_280_RGB_V2_LCD_białe.jpg
242	7	28	ENDORFY Aquarius 8000 Corona	599.00	\N	7	0	products/case/ENDORFY_Aquarius_8000_Corona.jpg
243	7	49	SMX Cassette	249.00	149.00	11	0	products/case/SMX_Cassette.jpg
244	7	49	SMX Coffer	179.00	129.00	12	0	products/case/SMX_Coffer.jpg
245	7	49	SMX Chest TG	219.00	\N	10	0	products/case/SMX_Chest_TG.jpg
246	7	47	Genesis DIAXID 605F Czarna	328.00	269.00	9	0	products/case/Genesis_DIAXID_605F_Czarna.jpg
247	7	49	SMX Croft	259.00	\N	13	0	products/case/SMX_Croft.jpg
248	7	31	Lian Li DAN A3 Wood Black	369.00	\N	7	0	products/case/Lian_Li_DAN_A3_Wood_Black.jpg
249	7	34	Fractal Design Meshify 3 Ambience Pro RGB Black TG Light Tint	889.00	\N	5	0	products/case/Fractal_Design_Meshify_3_Ambience_Pro_RGB_Black_TG_Light_Tint.jpg
250	7	28	ENDORFY Arx 700 Air	449.00	\N	6	0	products/case/ENDORFY_Arx_700_Air.jpg
251	7	31	Lian Li O11D EVO RGB Black	739.00	\N	4	0	products/case/Lian_Li_O11D_EVO_RGB_Black.jpg
252	7	5	MSI MAG PANO 100R PZ	469.00	419.00	8	0	products/case/MSI_MAG_PANO_100R_PZ.jpg
253	7	50	Deepcool CC560 ARGB	239.00	189.00	13	0	products/case/Deepcool_CC560_ARGB.jpg
254	7	49	SMX Capsule	299.00	\N	8	0	products/case/SMX_Capsule.jpg
255	7	16	NZXT H7 FLOW (2024) White	459.00	\N	5	0	products/case/NZXT_H7_FLOW_(2024)_White.jpg
256	7	49	SMX Pyxis	329.00	\N	6	0	products/case/SMX_Pyxis.jpg
257	7	31	Lian Li Lancool 217 Black	499.00	\N	5	0	products/case/Lian_Li_Lancool_217_Black.jpg
258	7	46	KRUX Helio	219.00	179.00	14	0	products/case/KRUX_Helio.jpg
259	7	29	be quiet! Pure Base 500DX Black	389.00	\N	8	0	products/case/be_quiet!_Pure_Base_500DX_Black.jpg
260	7	46	KRUX Vako	169.00	139.00	11	0	products/case/KRUX_Vako.jpg
261	7	28	ENDORFY Ventum 200 ARGB	299.00	\N	15	0	products/case/ENDORFY_Ventum_200_ARGB.jpg
262	7	4	ASUS TUF GAMING GT502 HORIZON TG ARGB White	779.00	\N	7	0	products/case/ASUS_TUF_GAMING_GT502_HORIZON_TG_ARGB_White.jpg
263	7	51	DarkFlash DS900W Black	199.00	\N	16	0	products/case/DarkFlash_DS900W_Black.jpg
264	7	51	DarkFlash DB330M Mesh White	139.00	\N	15	0	products/case/DarkFlash_DB330M_Mesh_White.jpg
265	7	51	DarkFlash DS900 Mesh Black	199.00	\N	14	0	products/case/DarkFlash_DS900_Mesh_Black.jpg
266	7	51	DarkFlash DB330M Mesh Black	139.00	\N	13	0	products/case/DarkFlash_DB330M_Mesh_Black.jpg
267	7	28	ENDORFY Regnum 400 ARGB	449.00	359.00	9	0	products/case/ENDORFY_Regnum_400_ARGB.jpg
269	7	51	DarkFlash DS900WS + 4 Fans Black	239.00	\N	8	0	products/case/DarkFlash_DS900WS_+_4_Fans_Black.jpg
270	7	16	NZXT H9 FLOW (2025) Black	749.00	\N	6	0	products/case/NZXT_H9_FLOW_(2025)_Black.jpg
271	7	29	be quiet! Light Base 500	509.00	\N	7	0	products/case/be_quiet!_Light_Base_500.jpg
272	7	29	be quiet! PURE BASE 501	389.00	\N	8	0	products/case/be_quiet!_PURE_BASE_501.jpg
\.


--
-- TOC entry 5874 (class 0 OID 34281)
-- Dependencies: 285
-- Data for Name: reviews; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reviews (id, product_id, user_id, rating, comment, created_at) FROM stdin;
\.


--
-- TOC entry 5876 (class 0 OID 34290)
-- Dependencies: 287
-- Data for Name: shipping_methods; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.shipping_methods (id, name, price) FROM stdin;
\.


--
-- TOC entry 5878 (class 0 OID 34297)
-- Dependencies: 289
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, email, password_hash, first_name, last_name, phone, "is_Admin") FROM stdin;
\.


--
-- TOC entry 5880 (class 0 OID 34306)
-- Dependencies: 291
-- Data for Name: wishlist_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.wishlist_items (wishlist_id, product_id) FROM stdin;
\.


--
-- TOC entry 5881 (class 0 OID 34311)
-- Dependencies: 292
-- Data for Name: wishlists; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.wishlists (id, user_id, name) FROM stdin;
\.


--
-- TOC entry 5883 (class 0 OID 34328)
-- Dependencies: 295
-- Data for Name: schema_migrations; Type: TABLE DATA; Schema: realtime; Owner: postgres
--

COPY realtime.schema_migrations (version, inserted_at) FROM stdin;
20211116024918	2026-04-06 11:01:13
20211116045059	2026-04-06 11:01:13
20211116050929	2026-04-06 11:01:13
20211116051442	2026-04-06 11:01:13
20211116212300	2026-04-06 11:01:13
20211116213355	2026-04-06 11:01:13
20211116213934	2026-04-06 11:01:13
20211116214523	2026-04-06 11:01:13
20211122062447	2026-04-06 11:01:13
20211124070109	2026-04-06 11:01:13
20211202204204	2026-04-06 11:01:13
20211202204605	2026-04-06 11:01:13
20211210212804	2026-04-06 11:01:13
20211228014915	2026-04-06 11:01:13
20220107221237	2026-04-06 11:01:13
20220228202821	2026-04-06 11:01:13
20220312004840	2026-04-06 11:01:13
20220603231003	2026-04-06 11:01:13
20220603232444	2026-04-06 11:01:13
20220615214548	2026-04-06 11:01:13
20220712093339	2026-04-06 11:01:13
20220908172859	2026-04-06 11:01:13
20220916233421	2026-04-06 11:01:13
20230119133233	2026-04-06 11:01:13
20230128025114	2026-04-06 11:01:13
20230128025212	2026-04-06 11:01:13
20230227211149	2026-04-06 11:01:13
20230228184745	2026-04-06 11:01:13
20230308225145	2026-04-06 11:01:13
20230328144023	2026-04-06 11:01:13
20231018144023	2026-04-06 11:01:13
20231204144023	2026-04-06 11:01:14
20231204144024	2026-04-06 11:01:14
20231204144025	2026-04-06 11:01:14
20240108234812	2026-04-06 11:01:14
20240109165339	2026-04-06 11:01:14
20240227174441	2026-04-06 11:01:14
20240311171622	2026-04-06 11:01:14
20240321100241	2026-04-06 11:01:14
20240401105812	2026-04-06 11:01:14
20240418121054	2026-04-06 11:01:14
20240523004032	2026-04-06 11:01:14
20240618124746	2026-04-06 11:01:14
20240801235015	2026-04-06 11:01:14
20240805133720	2026-04-06 11:01:14
20240827160934	2026-04-06 11:01:14
20240919163303	2026-04-06 11:01:14
20240919163305	2026-04-06 11:01:14
20241019105805	2026-04-06 11:01:14
20241030150047	2026-04-06 11:01:14
20241108114728	2026-04-06 11:01:14
20241121104152	2026-04-06 11:01:14
20241130184212	2026-04-06 11:01:14
20241220035512	2026-04-06 11:01:14
20241220123912	2026-04-06 11:01:14
20241224161212	2026-04-06 11:01:14
20250107150512	2026-04-06 11:01:14
20250110162412	2026-04-06 11:01:14
20250123174212	2026-04-06 11:01:14
20250128220012	2026-04-06 11:01:14
20250506224012	2026-04-06 11:01:14
20250523164012	2026-04-06 11:01:14
20250714121412	2026-04-06 11:01:14
20250905041441	2026-04-06 11:01:14
20251103001201	2026-04-06 11:01:14
20251120212548	2026-04-06 11:01:14
20251120215549	2026-04-06 11:01:14
20260218120000	2026-04-06 11:01:14
20260326120000	2026-04-10 17:07:03
\.


--
-- TOC entry 5884 (class 0 OID 34332)
-- Dependencies: 296
-- Data for Name: subscription; Type: TABLE DATA; Schema: realtime; Owner: postgres
--

COPY realtime.subscription (id, subscription_id, entity, filters, claims, created_at, action_filter) FROM stdin;
\.


--
-- TOC entry 5886 (class 0 OID 34350)
-- Dependencies: 298
-- Data for Name: buckets; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.buckets (id, name, owner, created_at, updated_at, public, avif_autodetection, file_size_limit, allowed_mime_types, owner_id, type) FROM stdin;
png	png	\N	2026-04-06 14:16:57.691666+02	2026-04-06 14:16:57.691666+02	t	f	\N	\N	\N	STANDARD
\.


--
-- TOC entry 5887 (class 0 OID 34363)
-- Dependencies: 299
-- Data for Name: buckets_analytics; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.buckets_analytics (name, type, format, created_at, updated_at, id, deleted_at) FROM stdin;
\.


--
-- TOC entry 5888 (class 0 OID 34379)
-- Dependencies: 300
-- Data for Name: buckets_vectors; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.buckets_vectors (id, type, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5889 (class 0 OID 34391)
-- Dependencies: 301
-- Data for Name: migrations; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.migrations (id, name, hash, executed_at) FROM stdin;
0	create-migrations-table	e18db593bcde2aca2a408c4d1100f6abba2195df	2026-04-06 10:28:21.733993
1	initialmigration	6ab16121fbaa08bbd11b712d05f358f9b555d777	2026-04-06 10:28:21.785506
2	storage-schema	f6a1fa2c93cbcd16d4e487b362e45fca157a8dbd	2026-04-06 10:28:21.790593
3	pathtoken-column	2cb1b0004b817b29d5b0a971af16bafeede4b70d	2026-04-06 10:28:21.835245
4	add-migrations-rls	427c5b63fe1c5937495d9c635c263ee7a5905058	2026-04-06 10:28:21.855483
5	add-size-functions	79e081a1455b63666c1294a440f8ad4b1e6a7f84	2026-04-06 10:28:21.861901
6	change-column-name-in-get-size	ded78e2f1b5d7e616117897e6443a925965b30d2	2026-04-06 10:28:21.870567
7	add-rls-to-buckets	e7e7f86adbc51049f341dfe8d30256c1abca17aa	2026-04-06 10:28:21.878124
8	add-public-to-buckets	fd670db39ed65f9d08b01db09d6202503ca2bab3	2026-04-06 10:28:21.884321
9	fix-search-function	af597a1b590c70519b464a4ab3be54490712796b	2026-04-06 10:28:21.88883
10	search-files-search-function	b595f05e92f7e91211af1bbfe9c6a13bb3391e16	2026-04-06 10:28:21.893306
11	add-trigger-to-auto-update-updated_at-column	7425bdb14366d1739fa8a18c83100636d74dcaa2	2026-04-06 10:28:21.898311
12	add-automatic-avif-detection-flag	8e92e1266eb29518b6a4c5313ab8f29dd0d08df9	2026-04-06 10:28:21.91018
13	add-bucket-custom-limits	cce962054138135cd9a8c4bcd531598684b25e7d	2026-04-06 10:28:21.923042
14	use-bytes-for-max-size	941c41b346f9802b411f06f30e972ad4744dad27	2026-04-06 10:28:21.928275
15	add-can-insert-object-function	934146bc38ead475f4ef4b555c524ee5d66799e5	2026-04-06 10:28:22.013821
16	add-version	76debf38d3fd07dcfc747ca49096457d95b1221b	2026-04-06 10:28:22.020373
17	drop-owner-foreign-key	f1cbb288f1b7a4c1eb8c38504b80ae2a0153d101	2026-04-06 10:28:22.026225
18	add_owner_id_column_deprecate_owner	e7a511b379110b08e2f214be852c35414749fe66	2026-04-06 10:28:22.032521
19	alter-default-value-objects-id	02e5e22a78626187e00d173dc45f58fa66a4f043	2026-04-06 10:28:22.046544
20	list-objects-with-delimiter	cd694ae708e51ba82bf012bba00caf4f3b6393b7	2026-04-06 10:28:22.054011
21	s3-multipart-uploads	8c804d4a566c40cd1e4cc5b3725a664a9303657f	2026-04-06 10:28:22.065145
22	s3-multipart-uploads-big-ints	9737dc258d2397953c9953d9b86920b8be0cdb73	2026-04-06 10:28:22.091541
23	optimize-search-function	9d7e604cddc4b56a5422dc68c9313f4a1b6f132c	2026-04-06 10:28:22.11588
24	operation-function	8312e37c2bf9e76bbe841aa5fda889206d2bf8aa	2026-04-06 10:28:22.12205
25	custom-metadata	d974c6057c3db1c1f847afa0e291e6165693b990	2026-04-06 10:28:22.126545
26	objects-prefixes	215cabcb7f78121892a5a2037a09fedf9a1ae322	2026-04-06 10:28:22.131087
27	search-v2	859ba38092ac96eb3964d83bf53ccc0b141663a6	2026-04-06 10:28:22.135639
28	object-bucket-name-sorting	c73a2b5b5d4041e39705814fd3a1b95502d38ce4	2026-04-06 10:28:22.139669
29	create-prefixes	ad2c1207f76703d11a9f9007f821620017a66c21	2026-04-06 10:28:22.144171
30	update-object-levels	2be814ff05c8252fdfdc7cfb4b7f5c7e17f0bed6	2026-04-06 10:28:22.150416
31	objects-level-index	b40367c14c3440ec75f19bbce2d71e914ddd3da0	2026-04-06 10:28:22.154392
32	backward-compatible-index-on-objects	e0c37182b0f7aee3efd823298fb3c76f1042c0f7	2026-04-06 10:28:22.160247
33	backward-compatible-index-on-prefixes	b480e99ed951e0900f033ec4eb34b5bdcb4e3d49	2026-04-06 10:28:22.163994
34	optimize-search-function-v1	ca80a3dc7bfef894df17108785ce29a7fc8ee456	2026-04-06 10:28:22.168634
35	add-insert-trigger-prefixes	458fe0ffd07ec53f5e3ce9df51bfdf4861929ccc	2026-04-06 10:28:22.173623
36	optimise-existing-functions	6ae5fca6af5c55abe95369cd4f93985d1814ca8f	2026-04-06 10:28:22.179568
37	add-bucket-name-length-trigger	3944135b4e3e8b22d6d4cbb568fe3b0b51df15c1	2026-04-06 10:28:22.183325
38	iceberg-catalog-flag-on-buckets	02716b81ceec9705aed84aa1501657095b32e5c5	2026-04-06 10:28:22.18869
39	add-search-v2-sort-support	6706c5f2928846abee18461279799ad12b279b78	2026-04-06 10:28:22.203616
40	fix-prefix-race-conditions-optimized	7ad69982ae2d372b21f48fc4829ae9752c518f6b	2026-04-06 10:28:22.208786
41	add-object-level-update-trigger	07fcf1a22165849b7a029deed059ffcde08d1ae0	2026-04-06 10:28:22.213339
42	rollback-prefix-triggers	771479077764adc09e2ea2043eb627503c034cd4	2026-04-06 10:28:22.218323
43	fix-object-level	84b35d6caca9d937478ad8a797491f38b8c2979f	2026-04-06 10:28:22.228341
44	vector-bucket-type	99c20c0ffd52bb1ff1f32fb992f3b351e3ef8fb3	2026-04-06 10:28:22.235502
45	vector-buckets	049e27196d77a7cb76497a85afae669d8b230953	2026-04-06 10:28:22.242524
46	buckets-objects-grants	fedeb96d60fefd8e02ab3ded9fbde05632f84aed	2026-04-06 10:28:22.275416
47	iceberg-table-metadata	649df56855c24d8b36dd4cc1aeb8251aa9ad42c2	2026-04-06 10:28:22.283047
48	iceberg-catalog-ids	e0e8b460c609b9999ccd0df9ad14294613eed939	2026-04-06 10:28:22.400177
49	buckets-objects-grants-postgres	072b1195d0d5a2f888af6b2302a1938dd94b8b3d	2026-04-06 10:28:22.44261
50	search-v2-optimised	6323ac4f850aa14e7387eb32102869578b5bd478	2026-04-06 10:28:22.45144
51	index-backward-compatible-search	2ee395d433f76e38bcd3856debaf6e0e5b674011	2026-04-06 10:28:27.735061
52	drop-not-used-indexes-and-functions	5cc44c8696749ac11dd0dc37f2a3802075f3a171	2026-04-06 10:28:27.773562
53	drop-index-lower-name	d0cb18777d9e2a98ebe0bc5cc7a42e57ebe41854	2026-04-06 10:28:27.814776
54	drop-index-object-level	6289e048b1472da17c31a7eba1ded625a6457e67	2026-04-06 10:28:27.816878
55	prevent-direct-deletes	262a4798d5e0f2e7c8970232e03ce8be695d5819	2026-04-06 10:28:27.818171
56	fix-optimized-search-function	cb58526ebc23048049fd5bf2fd148d18b04a2073	2026-04-06 10:28:27.828875
57	s3-multipart-uploads-metadata	f127886e00d1b374fadbc7c6b31e09336aad5287	2026-04-06 19:35:38.220016
58	operation-ergonomics	00ca5d483b3fe0d522133d9002ccc5df98365120	2026-04-06 19:35:38.251175
\.


--
-- TOC entry 5890 (class 0 OID 34398)
-- Dependencies: 302
-- Data for Name: objects; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.objects (id, bucket_id, name, owner, created_at, updated_at, last_accessed_at, metadata, version, owner_id, user_metadata) FROM stdin;
10eea89a-6e44-47a8-916e-e9bf13641b75	png	procesory/Ryzen_7_7800X3D.jpg	\N	2026-04-06 14:17:30.485425+02	2026-04-06 14:17:30.485425+02	2026-04-06 14:17:30.485425+02	{"eTag": "\\"d72c21fcc853111fc265ad059ef02a6a-1\\"", "size": 38805, "mimetype": "image/jpeg", "cacheControl": "max-age=3600", "lastModified": "2026-04-06T12:17:31.000Z", "contentLength": 38805, "httpStatusCode": 200}	fe5fc821-a115-4ec6-8e0a-71e95ebda099	\N	\N
a550e069-d979-4d8f-9485-11f891c7e59a	png	procesory/Ryzen 9 9800X3D.jpg	\N	2026-04-06 14:17:30.545076+02	2026-04-06 14:17:30.545076+02	2026-04-06 14:17:30.545076+02	{"eTag": "\\"fffbf201467cdf5a7886f7d480fcae7b-1\\"", "size": 80386, "mimetype": "image/jpeg", "cacheControl": "max-age=3600", "lastModified": "2026-04-06T12:17:31.000Z", "contentLength": 80386, "httpStatusCode": 200}	95008e24-13b2-43ce-a320-c7bfd7c48681	\N	\N
66c797f5-d14f-40c1-aeca-33ee58d1ba6b	png	karty graficzne/Radeon-RX-6700-XT.png	\N	2026-04-06 14:18:30.106591+02	2026-04-06 14:18:30.106591+02	2026-04-06 14:18:30.106591+02	{"eTag": "\\"2924931887194a1a94b273ef0c09e5d1-1\\"", "size": 5364, "mimetype": "image/png", "cacheControl": "max-age=3600", "lastModified": "2026-04-06T12:18:30.000Z", "contentLength": 5364, "httpStatusCode": 200}	e923c1d7-58a8-451d-b8f3-2fc4dfc16b5d	\N	\N
\.


--
-- TOC entry 5891 (class 0 OID 34409)
-- Dependencies: 303
-- Data for Name: s3_multipart_uploads; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.s3_multipart_uploads (id, in_progress_size, upload_signature, bucket_id, key, version, owner_id, created_at, user_metadata, metadata) FROM stdin;
\.


--
-- TOC entry 5892 (class 0 OID 34423)
-- Dependencies: 304
-- Data for Name: s3_multipart_uploads_parts; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.s3_multipart_uploads_parts (id, upload_id, size, part_number, bucket_id, key, etag, owner_id, version, created_at) FROM stdin;
\.


--
-- TOC entry 5893 (class 0 OID 34440)
-- Dependencies: 305
-- Data for Name: vector_indexes; Type: TABLE DATA; Schema: storage; Owner: postgres
--

COPY storage.vector_indexes (id, name, bucket_id, data_type, dimension, distance_metric, metadata_configuration, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 5957 (class 0 OID 0)
-- Dependencies: 249
-- Name: refresh_tokens_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: postgres
--

SELECT pg_catalog.setval('auth.refresh_tokens_id_seq', 1, false);


--
-- TOC entry 5958 (class 0 OID 0)
-- Dependencies: 260
-- Name: Bans_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Bans_id_seq"', 1, false);


--
-- TOC entry 5959 (class 0 OID 0)
-- Dependencies: 262
-- Name: addresses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.addresses_id_seq', 1, false);


--
-- TOC entry 5960 (class 0 OID 0)
-- Dependencies: 265
-- Name: attribute_values_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attribute_values_id_seq', 245, true);


--
-- TOC entry 5961 (class 0 OID 0)
-- Dependencies: 266
-- Name: attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attributes_id_seq', 39, true);


--
-- TOC entry 5962 (class 0 OID 0)
-- Dependencies: 268
-- Name: brands_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.brands_id_seq', 51, true);


--
-- TOC entry 5963 (class 0 OID 0)
-- Dependencies: 270
-- Name: cart_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.cart_items_id_seq', 1, false);


--
-- TOC entry 5964 (class 0 OID 0)
-- Dependencies: 272
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_id_seq', 14, true);


--
-- TOC entry 5965 (class 0 OID 0)
-- Dependencies: 274
-- Name: category_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.category_attributes_id_seq', 50, true);


--
-- TOC entry 5966 (class 0 OID 0)
-- Dependencies: 276
-- Name: complaints_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.complaints_id_seq', 1, false);


--
-- TOC entry 5967 (class 0 OID 0)
-- Dependencies: 278
-- Name: order_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.order_items_id_seq', 1, false);


--
-- TOC entry 5968 (class 0 OID 0)
-- Dependencies: 280
-- Name: orders_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.orders_id_seq', 1, false);


--
-- TOC entry 5969 (class 0 OID 0)
-- Dependencies: 282
-- Name: product_attributes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_attributes_id_seq', 999, true);


--
-- TOC entry 5970 (class 0 OID 0)
-- Dependencies: 284
-- Name: products_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.products_id_seq', 272, true);


--
-- TOC entry 5971 (class 0 OID 0)
-- Dependencies: 286
-- Name: reviews_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reviews_id_seq', 1, false);


--
-- TOC entry 5972 (class 0 OID 0)
-- Dependencies: 288
-- Name: shipping_methods_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.shipping_methods_id_seq', 1, false);


--
-- TOC entry 5973 (class 0 OID 0)
-- Dependencies: 290
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- TOC entry 5974 (class 0 OID 0)
-- Dependencies: 293
-- Name: wishlists_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.wishlists_id_seq', 1, false);


--
-- TOC entry 5975 (class 0 OID 0)
-- Dependencies: 297
-- Name: subscription_id_seq; Type: SEQUENCE SET; Schema: realtime; Owner: postgres
--

SELECT pg_catalog.setval('realtime.subscription_id_seq', 1, false);


--
-- TOC entry 5416 (class 2606 OID 34474)
-- Name: mfa_amr_claims amr_id_pk; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_amr_claims
    ADD CONSTRAINT amr_id_pk PRIMARY KEY (id);


--
-- TOC entry 5392 (class 2606 OID 34476)
-- Name: audit_log_entries audit_log_entries_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.audit_log_entries
    ADD CONSTRAINT audit_log_entries_pkey PRIMARY KEY (id);


--
-- TOC entry 5398 (class 2606 OID 34478)
-- Name: custom_oauth_providers custom_oauth_providers_identifier_key; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.custom_oauth_providers
    ADD CONSTRAINT custom_oauth_providers_identifier_key UNIQUE (identifier);


--
-- TOC entry 5400 (class 2606 OID 34480)
-- Name: custom_oauth_providers custom_oauth_providers_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.custom_oauth_providers
    ADD CONSTRAINT custom_oauth_providers_pkey PRIMARY KEY (id);


--
-- TOC entry 5404 (class 2606 OID 34482)
-- Name: flow_state flow_state_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.flow_state
    ADD CONSTRAINT flow_state_pkey PRIMARY KEY (id);


--
-- TOC entry 5409 (class 2606 OID 34484)
-- Name: identities identities_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.identities
    ADD CONSTRAINT identities_pkey PRIMARY KEY (id);


--
-- TOC entry 5411 (class 2606 OID 34486)
-- Name: identities identities_provider_id_provider_unique; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.identities
    ADD CONSTRAINT identities_provider_id_provider_unique UNIQUE (provider_id, provider);


--
-- TOC entry 5414 (class 2606 OID 34488)
-- Name: instances instances_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.instances
    ADD CONSTRAINT instances_pkey PRIMARY KEY (id);


--
-- TOC entry 5418 (class 2606 OID 34490)
-- Name: mfa_amr_claims mfa_amr_claims_session_id_authentication_method_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_amr_claims
    ADD CONSTRAINT mfa_amr_claims_session_id_authentication_method_pkey UNIQUE (session_id, authentication_method);


--
-- TOC entry 5421 (class 2606 OID 34492)
-- Name: mfa_challenges mfa_challenges_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_challenges
    ADD CONSTRAINT mfa_challenges_pkey PRIMARY KEY (id);


--
-- TOC entry 5424 (class 2606 OID 34494)
-- Name: mfa_factors mfa_factors_last_challenged_at_key; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_factors
    ADD CONSTRAINT mfa_factors_last_challenged_at_key UNIQUE (last_challenged_at);


--
-- TOC entry 5426 (class 2606 OID 34496)
-- Name: mfa_factors mfa_factors_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_factors
    ADD CONSTRAINT mfa_factors_pkey PRIMARY KEY (id);


--
-- TOC entry 5432 (class 2606 OID 34498)
-- Name: oauth_authorizations oauth_authorizations_authorization_code_key; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_authorizations
    ADD CONSTRAINT oauth_authorizations_authorization_code_key UNIQUE (authorization_code);


--
-- TOC entry 5434 (class 2606 OID 34500)
-- Name: oauth_authorizations oauth_authorizations_authorization_id_key; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_authorizations
    ADD CONSTRAINT oauth_authorizations_authorization_id_key UNIQUE (authorization_id);


--
-- TOC entry 5436 (class 2606 OID 34502)
-- Name: oauth_authorizations oauth_authorizations_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_authorizations
    ADD CONSTRAINT oauth_authorizations_pkey PRIMARY KEY (id);


--
-- TOC entry 5439 (class 2606 OID 34504)
-- Name: oauth_client_states oauth_client_states_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_client_states
    ADD CONSTRAINT oauth_client_states_pkey PRIMARY KEY (id);


--
-- TOC entry 5442 (class 2606 OID 34506)
-- Name: oauth_clients oauth_clients_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_clients
    ADD CONSTRAINT oauth_clients_pkey PRIMARY KEY (id);


--
-- TOC entry 5446 (class 2606 OID 34508)
-- Name: oauth_consents oauth_consents_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_consents
    ADD CONSTRAINT oauth_consents_pkey PRIMARY KEY (id);


--
-- TOC entry 5448 (class 2606 OID 34510)
-- Name: oauth_consents oauth_consents_user_client_unique; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_consents
    ADD CONSTRAINT oauth_consents_user_client_unique UNIQUE (user_id, client_id);


--
-- TOC entry 5451 (class 2606 OID 34512)
-- Name: one_time_tokens one_time_tokens_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.one_time_tokens
    ADD CONSTRAINT one_time_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 5459 (class 2606 OID 34514)
-- Name: refresh_tokens refresh_tokens_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.refresh_tokens
    ADD CONSTRAINT refresh_tokens_pkey PRIMARY KEY (id);


--
-- TOC entry 5462 (class 2606 OID 34516)
-- Name: refresh_tokens refresh_tokens_token_unique; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.refresh_tokens
    ADD CONSTRAINT refresh_tokens_token_unique UNIQUE (token);


--
-- TOC entry 5465 (class 2606 OID 34518)
-- Name: saml_providers saml_providers_entity_id_key; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.saml_providers
    ADD CONSTRAINT saml_providers_entity_id_key UNIQUE (entity_id);


--
-- TOC entry 5467 (class 2606 OID 34520)
-- Name: saml_providers saml_providers_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.saml_providers
    ADD CONSTRAINT saml_providers_pkey PRIMARY KEY (id);


--
-- TOC entry 5472 (class 2606 OID 34522)
-- Name: saml_relay_states saml_relay_states_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.saml_relay_states
    ADD CONSTRAINT saml_relay_states_pkey PRIMARY KEY (id);


--
-- TOC entry 5475 (class 2606 OID 34524)
-- Name: schema_migrations schema_migrations_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.schema_migrations
    ADD CONSTRAINT schema_migrations_pkey PRIMARY KEY (version);


--
-- TOC entry 5479 (class 2606 OID 34526)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 5484 (class 2606 OID 34528)
-- Name: sso_domains sso_domains_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.sso_domains
    ADD CONSTRAINT sso_domains_pkey PRIMARY KEY (id);


--
-- TOC entry 5487 (class 2606 OID 34530)
-- Name: sso_providers sso_providers_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.sso_providers
    ADD CONSTRAINT sso_providers_pkey PRIMARY KEY (id);


--
-- TOC entry 5500 (class 2606 OID 34532)
-- Name: users users_phone_key; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.users
    ADD CONSTRAINT users_phone_key UNIQUE (phone);


--
-- TOC entry 5502 (class 2606 OID 34534)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 5505 (class 2606 OID 34536)
-- Name: webauthn_challenges webauthn_challenges_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.webauthn_challenges
    ADD CONSTRAINT webauthn_challenges_pkey PRIMARY KEY (id);


--
-- TOC entry 5509 (class 2606 OID 34538)
-- Name: webauthn_credentials webauthn_credentials_pkey; Type: CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.webauthn_credentials
    ADD CONSTRAINT webauthn_credentials_pkey PRIMARY KEY (id);


--
-- TOC entry 5512 (class 2606 OID 34540)
-- Name: Bans Bans_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Bans"
    ADD CONSTRAINT "Bans_pkey" PRIMARY KEY (id);


--
-- TOC entry 5514 (class 2606 OID 34542)
-- Name: addresses addresses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.addresses
    ADD CONSTRAINT addresses_pkey PRIMARY KEY (id);


--
-- TOC entry 5520 (class 2606 OID 34544)
-- Name: attribute_values attribute_values_attribute_id_value_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT attribute_values_attribute_id_value_key UNIQUE (attribute_cathegory_id, value);


--
-- TOC entry 5522 (class 2606 OID 34546)
-- Name: attribute_values attribute_values_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT attribute_values_pkey PRIMARY KEY (id);


--
-- TOC entry 5516 (class 2606 OID 34548)
-- Name: attribute_cathegory attributes_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_cathegory
    ADD CONSTRAINT attributes_name_key UNIQUE (name);


--
-- TOC entry 5518 (class 2606 OID 34550)
-- Name: attribute_cathegory attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_cathegory
    ADD CONSTRAINT attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 5524 (class 2606 OID 34552)
-- Name: brands brands_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.brands
    ADD CONSTRAINT brands_name_key UNIQUE (name);


--
-- TOC entry 5526 (class 2606 OID 34554)
-- Name: brands brands_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.brands
    ADD CONSTRAINT brands_pkey PRIMARY KEY (id);


--
-- TOC entry 5528 (class 2606 OID 34556)
-- Name: cart_items cart_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_pkey PRIMARY KEY (id);


--
-- TOC entry 5530 (class 2606 OID 34558)
-- Name: categories categories_name_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_key UNIQUE (name);


--
-- TOC entry 5532 (class 2606 OID 34560)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 5534 (class 2606 OID 34562)
-- Name: category_attributes category_attributes_category_id_attribute_id_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_attributes
    ADD CONSTRAINT category_attributes_category_id_attribute_id_key UNIQUE (category_id, attribute_id);


--
-- TOC entry 5536 (class 2606 OID 34564)
-- Name: category_attributes category_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_attributes
    ADD CONSTRAINT category_attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 5538 (class 2606 OID 34566)
-- Name: complaints complaints_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.complaints
    ADD CONSTRAINT complaints_pkey PRIMARY KEY (id);


--
-- TOC entry 5540 (class 2606 OID 34568)
-- Name: order_items order_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_pkey PRIMARY KEY (id);


--
-- TOC entry 5542 (class 2606 OID 34570)
-- Name: orders orders_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_pkey PRIMARY KEY (id);


--
-- TOC entry 5548 (class 2606 OID 34572)
-- Name: product_attributes product_attributes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_attributes
    ADD CONSTRAINT product_attributes_pkey PRIMARY KEY (id);


--
-- TOC entry 5550 (class 2606 OID 34574)
-- Name: products products_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_pkey PRIMARY KEY (id);


--
-- TOC entry 5552 (class 2606 OID 34576)
-- Name: reviews reviews_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_pkey PRIMARY KEY (id);


--
-- TOC entry 5554 (class 2606 OID 34578)
-- Name: shipping_methods shipping_methods_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.shipping_methods
    ADD CONSTRAINT shipping_methods_pkey PRIMARY KEY (id);


--
-- TOC entry 5556 (class 2606 OID 34580)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 5558 (class 2606 OID 34582)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 5560 (class 2606 OID 34584)
-- Name: wishlist_items wishlist_items_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist_items
    ADD CONSTRAINT wishlist_items_pkey PRIMARY KEY (wishlist_id, product_id);


--
-- TOC entry 5562 (class 2606 OID 34586)
-- Name: wishlists wishlists_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists
    ADD CONSTRAINT wishlists_pkey PRIMARY KEY (id);


--
-- TOC entry 5565 (class 2606 OID 34588)
-- Name: messages messages_pkey; Type: CONSTRAINT; Schema: realtime; Owner: postgres
--

ALTER TABLE ONLY realtime.messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (id, inserted_at);


--
-- TOC entry 5570 (class 2606 OID 34590)
-- Name: subscription pk_subscription; Type: CONSTRAINT; Schema: realtime; Owner: postgres
--

ALTER TABLE ONLY realtime.subscription
    ADD CONSTRAINT pk_subscription PRIMARY KEY (id);


--
-- TOC entry 5567 (class 2606 OID 34592)
-- Name: schema_migrations schema_migrations_pkey; Type: CONSTRAINT; Schema: realtime; Owner: postgres
--

ALTER TABLE ONLY realtime.schema_migrations
    ADD CONSTRAINT schema_migrations_pkey PRIMARY KEY (version);


--
-- TOC entry 5576 (class 2606 OID 34594)
-- Name: buckets_analytics buckets_analytics_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.buckets_analytics
    ADD CONSTRAINT buckets_analytics_pkey PRIMARY KEY (id);


--
-- TOC entry 5574 (class 2606 OID 34596)
-- Name: buckets buckets_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.buckets
    ADD CONSTRAINT buckets_pkey PRIMARY KEY (id);


--
-- TOC entry 5579 (class 2606 OID 34598)
-- Name: buckets_vectors buckets_vectors_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.buckets_vectors
    ADD CONSTRAINT buckets_vectors_pkey PRIMARY KEY (id);


--
-- TOC entry 5581 (class 2606 OID 34600)
-- Name: migrations migrations_name_key; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.migrations
    ADD CONSTRAINT migrations_name_key UNIQUE (name);


--
-- TOC entry 5583 (class 2606 OID 34602)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 5589 (class 2606 OID 34604)
-- Name: objects objects_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.objects
    ADD CONSTRAINT objects_pkey PRIMARY KEY (id);


--
-- TOC entry 5594 (class 2606 OID 34606)
-- Name: s3_multipart_uploads_parts s3_multipart_uploads_parts_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.s3_multipart_uploads_parts
    ADD CONSTRAINT s3_multipart_uploads_parts_pkey PRIMARY KEY (id);


--
-- TOC entry 5592 (class 2606 OID 34608)
-- Name: s3_multipart_uploads s3_multipart_uploads_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.s3_multipart_uploads
    ADD CONSTRAINT s3_multipart_uploads_pkey PRIMARY KEY (id);


--
-- TOC entry 5597 (class 2606 OID 34610)
-- Name: vector_indexes vector_indexes_pkey; Type: CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.vector_indexes
    ADD CONSTRAINT vector_indexes_pkey PRIMARY KEY (id);


--
-- TOC entry 5393 (class 1259 OID 34611)
-- Name: audit_logs_instance_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX audit_logs_instance_id_idx ON auth.audit_log_entries USING btree (instance_id);


--
-- TOC entry 5490 (class 1259 OID 34612)
-- Name: confirmation_token_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX confirmation_token_idx ON auth.users USING btree (confirmation_token) WHERE ((confirmation_token)::text !~ '^[0-9 ]*$'::text);


--
-- TOC entry 5394 (class 1259 OID 34613)
-- Name: custom_oauth_providers_created_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX custom_oauth_providers_created_at_idx ON auth.custom_oauth_providers USING btree (created_at);


--
-- TOC entry 5395 (class 1259 OID 34614)
-- Name: custom_oauth_providers_enabled_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX custom_oauth_providers_enabled_idx ON auth.custom_oauth_providers USING btree (enabled);


--
-- TOC entry 5396 (class 1259 OID 34615)
-- Name: custom_oauth_providers_identifier_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX custom_oauth_providers_identifier_idx ON auth.custom_oauth_providers USING btree (identifier);


--
-- TOC entry 5401 (class 1259 OID 34616)
-- Name: custom_oauth_providers_provider_type_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX custom_oauth_providers_provider_type_idx ON auth.custom_oauth_providers USING btree (provider_type);


--
-- TOC entry 5491 (class 1259 OID 34617)
-- Name: email_change_token_current_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX email_change_token_current_idx ON auth.users USING btree (email_change_token_current) WHERE ((email_change_token_current)::text !~ '^[0-9 ]*$'::text);


--
-- TOC entry 5492 (class 1259 OID 34618)
-- Name: email_change_token_new_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX email_change_token_new_idx ON auth.users USING btree (email_change_token_new) WHERE ((email_change_token_new)::text !~ '^[0-9 ]*$'::text);


--
-- TOC entry 5422 (class 1259 OID 34619)
-- Name: factor_id_created_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX factor_id_created_at_idx ON auth.mfa_factors USING btree (user_id, created_at);


--
-- TOC entry 5402 (class 1259 OID 34620)
-- Name: flow_state_created_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX flow_state_created_at_idx ON auth.flow_state USING btree (created_at DESC);


--
-- TOC entry 5407 (class 1259 OID 34621)
-- Name: identities_email_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX identities_email_idx ON auth.identities USING btree (email text_pattern_ops);


--
-- TOC entry 5976 (class 0 OID 0)
-- Dependencies: 5407
-- Name: INDEX identities_email_idx; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON INDEX auth.identities_email_idx IS 'Auth: Ensures indexed queries on the email column';


--
-- TOC entry 5412 (class 1259 OID 34622)
-- Name: identities_user_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX identities_user_id_idx ON auth.identities USING btree (user_id);


--
-- TOC entry 5405 (class 1259 OID 34623)
-- Name: idx_auth_code; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX idx_auth_code ON auth.flow_state USING btree (auth_code);


--
-- TOC entry 5437 (class 1259 OID 34624)
-- Name: idx_oauth_client_states_created_at; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX idx_oauth_client_states_created_at ON auth.oauth_client_states USING btree (created_at);


--
-- TOC entry 5406 (class 1259 OID 34625)
-- Name: idx_user_id_auth_method; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX idx_user_id_auth_method ON auth.flow_state USING btree (user_id, authentication_method);


--
-- TOC entry 5419 (class 1259 OID 34626)
-- Name: mfa_challenge_created_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX mfa_challenge_created_at_idx ON auth.mfa_challenges USING btree (created_at DESC);


--
-- TOC entry 5427 (class 1259 OID 34627)
-- Name: mfa_factors_user_friendly_name_unique; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX mfa_factors_user_friendly_name_unique ON auth.mfa_factors USING btree (friendly_name, user_id) WHERE (TRIM(BOTH FROM friendly_name) <> ''::text);


--
-- TOC entry 5428 (class 1259 OID 34628)
-- Name: mfa_factors_user_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX mfa_factors_user_id_idx ON auth.mfa_factors USING btree (user_id);


--
-- TOC entry 5430 (class 1259 OID 34629)
-- Name: oauth_auth_pending_exp_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX oauth_auth_pending_exp_idx ON auth.oauth_authorizations USING btree (expires_at) WHERE (status = 'pending'::auth.oauth_authorization_status);


--
-- TOC entry 5440 (class 1259 OID 34630)
-- Name: oauth_clients_deleted_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX oauth_clients_deleted_at_idx ON auth.oauth_clients USING btree (deleted_at);


--
-- TOC entry 5443 (class 1259 OID 34631)
-- Name: oauth_consents_active_client_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX oauth_consents_active_client_idx ON auth.oauth_consents USING btree (client_id) WHERE (revoked_at IS NULL);


--
-- TOC entry 5444 (class 1259 OID 34632)
-- Name: oauth_consents_active_user_client_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX oauth_consents_active_user_client_idx ON auth.oauth_consents USING btree (user_id, client_id) WHERE (revoked_at IS NULL);


--
-- TOC entry 5449 (class 1259 OID 34633)
-- Name: oauth_consents_user_order_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX oauth_consents_user_order_idx ON auth.oauth_consents USING btree (user_id, granted_at DESC);


--
-- TOC entry 5452 (class 1259 OID 34634)
-- Name: one_time_tokens_relates_to_hash_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX one_time_tokens_relates_to_hash_idx ON auth.one_time_tokens USING hash (relates_to);


--
-- TOC entry 5453 (class 1259 OID 34635)
-- Name: one_time_tokens_token_hash_hash_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX one_time_tokens_token_hash_hash_idx ON auth.one_time_tokens USING hash (token_hash);


--
-- TOC entry 5454 (class 1259 OID 34636)
-- Name: one_time_tokens_user_id_token_type_key; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX one_time_tokens_user_id_token_type_key ON auth.one_time_tokens USING btree (user_id, token_type);


--
-- TOC entry 5493 (class 1259 OID 34637)
-- Name: reauthentication_token_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX reauthentication_token_idx ON auth.users USING btree (reauthentication_token) WHERE ((reauthentication_token)::text !~ '^[0-9 ]*$'::text);


--
-- TOC entry 5494 (class 1259 OID 34638)
-- Name: recovery_token_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX recovery_token_idx ON auth.users USING btree (recovery_token) WHERE ((recovery_token)::text !~ '^[0-9 ]*$'::text);


--
-- TOC entry 5455 (class 1259 OID 34639)
-- Name: refresh_tokens_instance_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX refresh_tokens_instance_id_idx ON auth.refresh_tokens USING btree (instance_id);


--
-- TOC entry 5456 (class 1259 OID 34640)
-- Name: refresh_tokens_instance_id_user_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX refresh_tokens_instance_id_user_id_idx ON auth.refresh_tokens USING btree (instance_id, user_id);


--
-- TOC entry 5457 (class 1259 OID 34641)
-- Name: refresh_tokens_parent_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX refresh_tokens_parent_idx ON auth.refresh_tokens USING btree (parent);


--
-- TOC entry 5460 (class 1259 OID 34642)
-- Name: refresh_tokens_session_id_revoked_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX refresh_tokens_session_id_revoked_idx ON auth.refresh_tokens USING btree (session_id, revoked);


--
-- TOC entry 5463 (class 1259 OID 34643)
-- Name: refresh_tokens_updated_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX refresh_tokens_updated_at_idx ON auth.refresh_tokens USING btree (updated_at DESC);


--
-- TOC entry 5468 (class 1259 OID 34644)
-- Name: saml_providers_sso_provider_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX saml_providers_sso_provider_id_idx ON auth.saml_providers USING btree (sso_provider_id);


--
-- TOC entry 5469 (class 1259 OID 34645)
-- Name: saml_relay_states_created_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX saml_relay_states_created_at_idx ON auth.saml_relay_states USING btree (created_at DESC);


--
-- TOC entry 5470 (class 1259 OID 34646)
-- Name: saml_relay_states_for_email_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX saml_relay_states_for_email_idx ON auth.saml_relay_states USING btree (for_email);


--
-- TOC entry 5473 (class 1259 OID 34647)
-- Name: saml_relay_states_sso_provider_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX saml_relay_states_sso_provider_id_idx ON auth.saml_relay_states USING btree (sso_provider_id);


--
-- TOC entry 5476 (class 1259 OID 34648)
-- Name: sessions_not_after_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX sessions_not_after_idx ON auth.sessions USING btree (not_after DESC);


--
-- TOC entry 5477 (class 1259 OID 34649)
-- Name: sessions_oauth_client_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX sessions_oauth_client_id_idx ON auth.sessions USING btree (oauth_client_id);


--
-- TOC entry 5480 (class 1259 OID 34650)
-- Name: sessions_user_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX sessions_user_id_idx ON auth.sessions USING btree (user_id);


--
-- TOC entry 5482 (class 1259 OID 34651)
-- Name: sso_domains_domain_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX sso_domains_domain_idx ON auth.sso_domains USING btree (lower(domain));


--
-- TOC entry 5485 (class 1259 OID 34652)
-- Name: sso_domains_sso_provider_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX sso_domains_sso_provider_id_idx ON auth.sso_domains USING btree (sso_provider_id);


--
-- TOC entry 5488 (class 1259 OID 34653)
-- Name: sso_providers_resource_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX sso_providers_resource_id_idx ON auth.sso_providers USING btree (lower(resource_id));


--
-- TOC entry 5489 (class 1259 OID 34654)
-- Name: sso_providers_resource_id_pattern_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX sso_providers_resource_id_pattern_idx ON auth.sso_providers USING btree (resource_id text_pattern_ops);


--
-- TOC entry 5429 (class 1259 OID 34655)
-- Name: unique_phone_factor_per_user; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX unique_phone_factor_per_user ON auth.mfa_factors USING btree (user_id, phone);


--
-- TOC entry 5481 (class 1259 OID 34656)
-- Name: user_id_created_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX user_id_created_at_idx ON auth.sessions USING btree (user_id, created_at);


--
-- TOC entry 5495 (class 1259 OID 34657)
-- Name: users_email_partial_key; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX users_email_partial_key ON auth.users USING btree (email) WHERE (is_sso_user = false);


--
-- TOC entry 5977 (class 0 OID 0)
-- Dependencies: 5495
-- Name: INDEX users_email_partial_key; Type: COMMENT; Schema: auth; Owner: postgres
--

COMMENT ON INDEX auth.users_email_partial_key IS 'Auth: A partial unique index that applies only when is_sso_user is false';


--
-- TOC entry 5496 (class 1259 OID 34658)
-- Name: users_instance_id_email_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX users_instance_id_email_idx ON auth.users USING btree (instance_id, lower((email)::text));


--
-- TOC entry 5497 (class 1259 OID 34659)
-- Name: users_instance_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX users_instance_id_idx ON auth.users USING btree (instance_id);


--
-- TOC entry 5498 (class 1259 OID 34660)
-- Name: users_is_anonymous_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX users_is_anonymous_idx ON auth.users USING btree (is_anonymous);


--
-- TOC entry 5503 (class 1259 OID 34661)
-- Name: webauthn_challenges_expires_at_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX webauthn_challenges_expires_at_idx ON auth.webauthn_challenges USING btree (expires_at);


--
-- TOC entry 5506 (class 1259 OID 34662)
-- Name: webauthn_challenges_user_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX webauthn_challenges_user_id_idx ON auth.webauthn_challenges USING btree (user_id);


--
-- TOC entry 5507 (class 1259 OID 34663)
-- Name: webauthn_credentials_credential_id_key; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE UNIQUE INDEX webauthn_credentials_credential_id_key ON auth.webauthn_credentials USING btree (credential_id);


--
-- TOC entry 5510 (class 1259 OID 34664)
-- Name: webauthn_credentials_user_id_idx; Type: INDEX; Schema: auth; Owner: postgres
--

CREATE INDEX webauthn_credentials_user_id_idx ON auth.webauthn_credentials USING btree (user_id);


--
-- TOC entry 5543 (class 1259 OID 34665)
-- Name: idx_pa_attr_number; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pa_attr_number ON public.product_attributes USING btree (attribute_cathegory_id, value_number);


--
-- TOC entry 5544 (class 1259 OID 34666)
-- Name: idx_pa_attr_text; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pa_attr_text ON public.product_attributes USING btree (attribute_cathegory_id, value_text);


--
-- TOC entry 5545 (class 1259 OID 34667)
-- Name: idx_pa_attr_val; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pa_attr_val ON public.product_attributes USING btree (attribute_cathegory_id, attribute_value_id);


--
-- TOC entry 5546 (class 1259 OID 34668)
-- Name: idx_pa_product; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pa_product ON public.product_attributes USING btree (product_id);


--
-- TOC entry 5568 (class 1259 OID 34669)
-- Name: ix_realtime_subscription_entity; Type: INDEX; Schema: realtime; Owner: postgres
--

CREATE INDEX ix_realtime_subscription_entity ON realtime.subscription USING btree (entity);


--
-- TOC entry 5563 (class 1259 OID 34670)
-- Name: messages_inserted_at_topic_index; Type: INDEX; Schema: realtime; Owner: postgres
--

CREATE INDEX messages_inserted_at_topic_index ON ONLY realtime.messages USING btree (inserted_at DESC, topic) WHERE ((extension = 'broadcast'::text) AND (private IS TRUE));


--
-- TOC entry 5571 (class 1259 OID 34671)
-- Name: subscription_subscription_id_entity_filters_action_filter_key; Type: INDEX; Schema: realtime; Owner: postgres
--

CREATE UNIQUE INDEX subscription_subscription_id_entity_filters_action_filter_key ON realtime.subscription USING btree (subscription_id, entity, filters, action_filter);


--
-- TOC entry 5572 (class 1259 OID 34672)
-- Name: bname; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE UNIQUE INDEX bname ON storage.buckets USING btree (name);


--
-- TOC entry 5584 (class 1259 OID 34673)
-- Name: bucketid_objname; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE UNIQUE INDEX bucketid_objname ON storage.objects USING btree (bucket_id, name);


--
-- TOC entry 5577 (class 1259 OID 34674)
-- Name: buckets_analytics_unique_name_idx; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE UNIQUE INDEX buckets_analytics_unique_name_idx ON storage.buckets_analytics USING btree (name) WHERE (deleted_at IS NULL);


--
-- TOC entry 5590 (class 1259 OID 34675)
-- Name: idx_multipart_uploads_list; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE INDEX idx_multipart_uploads_list ON storage.s3_multipart_uploads USING btree (bucket_id, key, created_at);


--
-- TOC entry 5585 (class 1259 OID 34676)
-- Name: idx_objects_bucket_id_name; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE INDEX idx_objects_bucket_id_name ON storage.objects USING btree (bucket_id, name COLLATE "C");


--
-- TOC entry 5586 (class 1259 OID 34677)
-- Name: idx_objects_bucket_id_name_lower; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE INDEX idx_objects_bucket_id_name_lower ON storage.objects USING btree (bucket_id, lower(name) COLLATE "C");


--
-- TOC entry 5587 (class 1259 OID 34678)
-- Name: name_prefix_search; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE INDEX name_prefix_search ON storage.objects USING btree (name text_pattern_ops);


--
-- TOC entry 5595 (class 1259 OID 34679)
-- Name: vector_indexes_name_bucket_id_idx; Type: INDEX; Schema: storage; Owner: postgres
--

CREATE UNIQUE INDEX vector_indexes_name_bucket_id_idx ON storage.vector_indexes USING btree (name, bucket_id);


--
-- TOC entry 5643 (class 2620 OID 34680)
-- Name: subscription tr_check_filters; Type: TRIGGER; Schema: realtime; Owner: postgres
--

CREATE TRIGGER tr_check_filters BEFORE INSERT OR UPDATE ON realtime.subscription FOR EACH ROW EXECUTE FUNCTION realtime.subscription_check_filters();


--
-- TOC entry 5644 (class 2620 OID 34681)
-- Name: buckets enforce_bucket_name_length_trigger; Type: TRIGGER; Schema: storage; Owner: postgres
--

CREATE TRIGGER enforce_bucket_name_length_trigger BEFORE INSERT OR UPDATE OF name ON storage.buckets FOR EACH ROW EXECUTE FUNCTION storage.enforce_bucket_name_length();


--
-- TOC entry 5645 (class 2620 OID 34682)
-- Name: buckets protect_buckets_delete; Type: TRIGGER; Schema: storage; Owner: postgres
--

CREATE TRIGGER protect_buckets_delete BEFORE DELETE ON storage.buckets FOR EACH STATEMENT EXECUTE FUNCTION storage.protect_delete();


--
-- TOC entry 5646 (class 2620 OID 34683)
-- Name: objects protect_objects_delete; Type: TRIGGER; Schema: storage; Owner: postgres
--

CREATE TRIGGER protect_objects_delete BEFORE DELETE ON storage.objects FOR EACH STATEMENT EXECUTE FUNCTION storage.protect_delete();


--
-- TOC entry 5647 (class 2620 OID 34684)
-- Name: objects update_objects_updated_at; Type: TRIGGER; Schema: storage; Owner: postgres
--

CREATE TRIGGER update_objects_updated_at BEFORE UPDATE ON storage.objects FOR EACH ROW EXECUTE FUNCTION storage.update_updated_at_column();


--
-- TOC entry 5598 (class 2606 OID 34685)
-- Name: identities identities_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.identities
    ADD CONSTRAINT identities_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5599 (class 2606 OID 34690)
-- Name: mfa_amr_claims mfa_amr_claims_session_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_amr_claims
    ADD CONSTRAINT mfa_amr_claims_session_id_fkey FOREIGN KEY (session_id) REFERENCES auth.sessions(id) ON DELETE CASCADE;


--
-- TOC entry 5600 (class 2606 OID 34695)
-- Name: mfa_challenges mfa_challenges_auth_factor_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_challenges
    ADD CONSTRAINT mfa_challenges_auth_factor_id_fkey FOREIGN KEY (factor_id) REFERENCES auth.mfa_factors(id) ON DELETE CASCADE;


--
-- TOC entry 5601 (class 2606 OID 34700)
-- Name: mfa_factors mfa_factors_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.mfa_factors
    ADD CONSTRAINT mfa_factors_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5602 (class 2606 OID 34705)
-- Name: oauth_authorizations oauth_authorizations_client_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_authorizations
    ADD CONSTRAINT oauth_authorizations_client_id_fkey FOREIGN KEY (client_id) REFERENCES auth.oauth_clients(id) ON DELETE CASCADE;


--
-- TOC entry 5603 (class 2606 OID 34710)
-- Name: oauth_authorizations oauth_authorizations_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_authorizations
    ADD CONSTRAINT oauth_authorizations_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5604 (class 2606 OID 34715)
-- Name: oauth_consents oauth_consents_client_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_consents
    ADD CONSTRAINT oauth_consents_client_id_fkey FOREIGN KEY (client_id) REFERENCES auth.oauth_clients(id) ON DELETE CASCADE;


--
-- TOC entry 5605 (class 2606 OID 34720)
-- Name: oauth_consents oauth_consents_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.oauth_consents
    ADD CONSTRAINT oauth_consents_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5606 (class 2606 OID 34725)
-- Name: one_time_tokens one_time_tokens_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.one_time_tokens
    ADD CONSTRAINT one_time_tokens_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5607 (class 2606 OID 34730)
-- Name: refresh_tokens refresh_tokens_session_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.refresh_tokens
    ADD CONSTRAINT refresh_tokens_session_id_fkey FOREIGN KEY (session_id) REFERENCES auth.sessions(id) ON DELETE CASCADE;


--
-- TOC entry 5608 (class 2606 OID 34735)
-- Name: saml_providers saml_providers_sso_provider_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.saml_providers
    ADD CONSTRAINT saml_providers_sso_provider_id_fkey FOREIGN KEY (sso_provider_id) REFERENCES auth.sso_providers(id) ON DELETE CASCADE;


--
-- TOC entry 5609 (class 2606 OID 34740)
-- Name: saml_relay_states saml_relay_states_flow_state_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.saml_relay_states
    ADD CONSTRAINT saml_relay_states_flow_state_id_fkey FOREIGN KEY (flow_state_id) REFERENCES auth.flow_state(id) ON DELETE CASCADE;


--
-- TOC entry 5610 (class 2606 OID 34745)
-- Name: saml_relay_states saml_relay_states_sso_provider_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.saml_relay_states
    ADD CONSTRAINT saml_relay_states_sso_provider_id_fkey FOREIGN KEY (sso_provider_id) REFERENCES auth.sso_providers(id) ON DELETE CASCADE;


--
-- TOC entry 5611 (class 2606 OID 34750)
-- Name: sessions sessions_oauth_client_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.sessions
    ADD CONSTRAINT sessions_oauth_client_id_fkey FOREIGN KEY (oauth_client_id) REFERENCES auth.oauth_clients(id) ON DELETE CASCADE;


--
-- TOC entry 5612 (class 2606 OID 34755)
-- Name: sessions sessions_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.sessions
    ADD CONSTRAINT sessions_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5613 (class 2606 OID 34760)
-- Name: sso_domains sso_domains_sso_provider_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.sso_domains
    ADD CONSTRAINT sso_domains_sso_provider_id_fkey FOREIGN KEY (sso_provider_id) REFERENCES auth.sso_providers(id) ON DELETE CASCADE;


--
-- TOC entry 5614 (class 2606 OID 34765)
-- Name: webauthn_challenges webauthn_challenges_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.webauthn_challenges
    ADD CONSTRAINT webauthn_challenges_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5615 (class 2606 OID 34770)
-- Name: webauthn_credentials webauthn_credentials_user_id_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: postgres
--

ALTER TABLE ONLY auth.webauthn_credentials
    ADD CONSTRAINT webauthn_credentials_user_id_fkey FOREIGN KEY (user_id) REFERENCES auth.users(id) ON DELETE CASCADE;


--
-- TOC entry 5616 (class 2606 OID 34775)
-- Name: Bans Bans_id_users_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."Bans"
    ADD CONSTRAINT "Bans_id_users_fkey" FOREIGN KEY (id_users) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 5617 (class 2606 OID 34780)
-- Name: addresses addresses_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.addresses
    ADD CONSTRAINT addresses_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5618 (class 2606 OID 34785)
-- Name: attribute_values attribute_values_attribute_cathegory_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attribute_values
    ADD CONSTRAINT attribute_values_attribute_cathegory_id_fkey FOREIGN KEY (attribute_cathegory_id) REFERENCES public.attribute_cathegory(id) ON DELETE CASCADE;


--
-- TOC entry 5619 (class 2606 OID 34790)
-- Name: cart_items cart_items_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 5620 (class 2606 OID 34795)
-- Name: cart_items cart_items_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cart_items
    ADD CONSTRAINT cart_items_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5621 (class 2606 OID 34800)
-- Name: category_attributes category_attributes_attribute_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_attributes
    ADD CONSTRAINT category_attributes_attribute_id_fkey FOREIGN KEY (attribute_id) REFERENCES public.attribute_cathegory(id) ON DELETE CASCADE;


--
-- TOC entry 5622 (class 2606 OID 34805)
-- Name: category_attributes category_attributes_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.category_attributes
    ADD CONSTRAINT category_attributes_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 5623 (class 2606 OID 34810)
-- Name: complaints complaints_order_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.complaints
    ADD CONSTRAINT complaints_order_id_fkey FOREIGN KEY (order_id) REFERENCES public.orders(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 5624 (class 2606 OID 34815)
-- Name: order_items order_items_order_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_order_id_fkey FOREIGN KEY (order_id) REFERENCES public.orders(id) ON DELETE CASCADE;


--
-- TOC entry 5625 (class 2606 OID 34820)
-- Name: order_items order_items_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.order_items
    ADD CONSTRAINT order_items_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id);


--
-- TOC entry 5626 (class 2606 OID 34825)
-- Name: orders orders_shipping_method_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_shipping_method_id_fkey FOREIGN KEY (shipping_method_id) REFERENCES public.shipping_methods(id);


--
-- TOC entry 5627 (class 2606 OID 34830)
-- Name: orders orders_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.orders
    ADD CONSTRAINT orders_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 5628 (class 2606 OID 34835)
-- Name: product_attributes product_attributes_attribute_cathegory_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_attributes
    ADD CONSTRAINT product_attributes_attribute_cathegory_id_fkey FOREIGN KEY (attribute_cathegory_id) REFERENCES public.attribute_cathegory(id) ON DELETE CASCADE;


--
-- TOC entry 5629 (class 2606 OID 34840)
-- Name: product_attributes product_attributes_attribute_value_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_attributes
    ADD CONSTRAINT product_attributes_attribute_value_id_fkey FOREIGN KEY (attribute_value_id) REFERENCES public.attribute_values(id);


--
-- TOC entry 5630 (class 2606 OID 34845)
-- Name: product_attributes product_attributes_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_attributes
    ADD CONSTRAINT product_attributes_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 5631 (class 2606 OID 34850)
-- Name: products products_brand_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_brand_id_fkey FOREIGN KEY (brand_id) REFERENCES public.brands(id);


--
-- TOC entry 5632 (class 2606 OID 34855)
-- Name: products products_category_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.products
    ADD CONSTRAINT products_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id);


--
-- TOC entry 5633 (class 2606 OID 34860)
-- Name: reviews reviews_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 5634 (class 2606 OID 34865)
-- Name: reviews reviews_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reviews
    ADD CONSTRAINT reviews_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id);


--
-- TOC entry 5635 (class 2606 OID 34870)
-- Name: wishlist_items wishlist_items_product_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist_items
    ADD CONSTRAINT wishlist_items_product_id_fkey FOREIGN KEY (product_id) REFERENCES public.products(id) ON DELETE CASCADE;


--
-- TOC entry 5636 (class 2606 OID 34875)
-- Name: wishlist_items wishlist_items_wishlist_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlist_items
    ADD CONSTRAINT wishlist_items_wishlist_id_fkey FOREIGN KEY (wishlist_id) REFERENCES public.wishlists(id) ON DELETE CASCADE;


--
-- TOC entry 5637 (class 2606 OID 34880)
-- Name: wishlists wishlists_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.wishlists
    ADD CONSTRAINT wishlists_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5638 (class 2606 OID 34885)
-- Name: objects objects_bucketId_fkey; Type: FK CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.objects
    ADD CONSTRAINT "objects_bucketId_fkey" FOREIGN KEY (bucket_id) REFERENCES storage.buckets(id);


--
-- TOC entry 5639 (class 2606 OID 34890)
-- Name: s3_multipart_uploads s3_multipart_uploads_bucket_id_fkey; Type: FK CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.s3_multipart_uploads
    ADD CONSTRAINT s3_multipart_uploads_bucket_id_fkey FOREIGN KEY (bucket_id) REFERENCES storage.buckets(id);


--
-- TOC entry 5640 (class 2606 OID 34895)
-- Name: s3_multipart_uploads_parts s3_multipart_uploads_parts_bucket_id_fkey; Type: FK CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.s3_multipart_uploads_parts
    ADD CONSTRAINT s3_multipart_uploads_parts_bucket_id_fkey FOREIGN KEY (bucket_id) REFERENCES storage.buckets(id);


--
-- TOC entry 5641 (class 2606 OID 34900)
-- Name: s3_multipart_uploads_parts s3_multipart_uploads_parts_upload_id_fkey; Type: FK CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.s3_multipart_uploads_parts
    ADD CONSTRAINT s3_multipart_uploads_parts_upload_id_fkey FOREIGN KEY (upload_id) REFERENCES storage.s3_multipart_uploads(id) ON DELETE CASCADE;


--
-- TOC entry 5642 (class 2606 OID 34905)
-- Name: vector_indexes vector_indexes_bucket_id_fkey; Type: FK CONSTRAINT; Schema: storage; Owner: postgres
--

ALTER TABLE ONLY storage.vector_indexes
    ADD CONSTRAINT vector_indexes_bucket_id_fkey FOREIGN KEY (bucket_id) REFERENCES storage.buckets_vectors(id);


--
-- TOC entry 5797 (class 0 OID 33873)
-- Dependencies: 235
-- Name: audit_log_entries; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.audit_log_entries ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5798 (class 0 OID 33931)
-- Dependencies: 237
-- Name: flow_state; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.flow_state ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5799 (class 0 OID 33941)
-- Dependencies: 238
-- Name: identities; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.identities ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5800 (class 0 OID 33953)
-- Dependencies: 239
-- Name: instances; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.instances ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5801 (class 0 OID 33959)
-- Dependencies: 240
-- Name: mfa_amr_claims; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.mfa_amr_claims ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5802 (class 0 OID 33969)
-- Dependencies: 241
-- Name: mfa_challenges; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.mfa_challenges ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5803 (class 0 OID 33978)
-- Dependencies: 242
-- Name: mfa_factors; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.mfa_factors ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5804 (class 0 OID 34057)
-- Dependencies: 247
-- Name: one_time_tokens; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.one_time_tokens ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5805 (class 0 OID 34072)
-- Dependencies: 248
-- Name: refresh_tokens; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.refresh_tokens ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5806 (class 0 OID 34079)
-- Dependencies: 250
-- Name: saml_providers; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.saml_providers ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5807 (class 0 OID 34091)
-- Dependencies: 251
-- Name: saml_relay_states; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.saml_relay_states ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5808 (class 0 OID 34100)
-- Dependencies: 252
-- Name: schema_migrations; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.schema_migrations ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5809 (class 0 OID 34104)
-- Dependencies: 253
-- Name: sessions; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.sessions ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5810 (class 0 OID 34112)
-- Dependencies: 254
-- Name: sso_domains; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.sso_domains ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5811 (class 0 OID 34121)
-- Dependencies: 255
-- Name: sso_providers; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.sso_providers ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5812 (class 0 OID 34128)
-- Dependencies: 256
-- Name: users; Type: ROW SECURITY; Schema: auth; Owner: postgres
--

ALTER TABLE auth.users ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5813 (class 0 OID 34185)
-- Dependencies: 259
-- Name: Bans; Type: ROW SECURITY; Schema: public; Owner: postgres
--

ALTER TABLE public."Bans" ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5814 (class 0 OID 34316)
-- Dependencies: 294
-- Name: messages; Type: ROW SECURITY; Schema: realtime; Owner: postgres
--

ALTER TABLE realtime.messages ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5815 (class 0 OID 34350)
-- Dependencies: 298
-- Name: buckets; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.buckets ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5816 (class 0 OID 34363)
-- Dependencies: 299
-- Name: buckets_analytics; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.buckets_analytics ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5817 (class 0 OID 34379)
-- Dependencies: 300
-- Name: buckets_vectors; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.buckets_vectors ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5818 (class 0 OID 34391)
-- Dependencies: 301
-- Name: migrations; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.migrations ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5819 (class 0 OID 34398)
-- Dependencies: 302
-- Name: objects; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.objects ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5820 (class 0 OID 34409)
-- Dependencies: 303
-- Name: s3_multipart_uploads; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.s3_multipart_uploads ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5821 (class 0 OID 34423)
-- Dependencies: 304
-- Name: s3_multipart_uploads_parts; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.s3_multipart_uploads_parts ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5822 (class 0 OID 34440)
-- Dependencies: 305
-- Name: vector_indexes; Type: ROW SECURITY; Schema: storage; Owner: postgres
--

ALTER TABLE storage.vector_indexes ENABLE ROW LEVEL SECURITY;

--
-- TOC entry 5823 (class 6104 OID 34910)
-- Name: supabase_realtime; Type: PUBLICATION; Schema: -; Owner: postgres
--

CREATE PUBLICATION supabase_realtime WITH (publish = 'insert, update, delete, truncate');


ALTER PUBLICATION supabase_realtime OWNER TO postgres;

--
-- TOC entry 5907 (class 0 OID 0)
-- Dependencies: 325
-- Name: FUNCTION grant_pg_graphql_access(); Type: ACL; Schema: extensions; Owner: postgres
--

REVOKE ALL ON FUNCTION extensions.grant_pg_graphql_access() FROM postgres;
GRANT ALL ON FUNCTION extensions.grant_pg_graphql_access() TO postgres WITH GRANT OPTION;


--
-- TOC entry 5909 (class 0 OID 0)
-- Dependencies: 385
-- Name: FUNCTION pgrst_ddl_watch(); Type: ACL; Schema: extensions; Owner: postgres
--

REVOKE ALL ON FUNCTION extensions.pgrst_ddl_watch() FROM postgres;
GRANT ALL ON FUNCTION extensions.pgrst_ddl_watch() TO postgres WITH GRANT OPTION;


--
-- TOC entry 5910 (class 0 OID 0)
-- Dependencies: 373
-- Name: FUNCTION pgrst_drop_watch(); Type: ACL; Schema: extensions; Owner: postgres
--

REVOKE ALL ON FUNCTION extensions.pgrst_drop_watch() FROM postgres;
GRANT ALL ON FUNCTION extensions.pgrst_drop_watch() TO postgres WITH GRANT OPTION;


--
-- TOC entry 5912 (class 0 OID 0)
-- Dependencies: 326
-- Name: FUNCTION set_graphql_placeholder(); Type: ACL; Schema: extensions; Owner: postgres
--

REVOKE ALL ON FUNCTION extensions.set_graphql_placeholder() FROM postgres;
GRANT ALL ON FUNCTION extensions.set_graphql_placeholder() TO postgres WITH GRANT OPTION;


--
-- TOC entry 5913 (class 0 OID 0)
-- Dependencies: 329
-- Name: FUNCTION pg_reload_conf(); Type: ACL; Schema: pg_catalog; Owner: postgres
--

REVOKE ALL ON FUNCTION pg_catalog.pg_reload_conf() FROM postgres;
GRANT ALL ON FUNCTION pg_catalog.pg_reload_conf() TO postgres WITH GRANT OPTION;


--
-- TOC entry 5929 (class 0 OID 0)
-- Dependencies: 252
-- Name: TABLE schema_migrations; Type: ACL; Schema: auth; Owner: postgres
--

REVOKE ALL ON TABLE auth.schema_migrations FROM postgres;
GRANT INSERT,REFERENCES,DELETE,TRIGGER,TRUNCATE,MAINTAIN,UPDATE ON TABLE auth.schema_migrations TO postgres;
GRANT SELECT ON TABLE auth.schema_migrations TO postgres WITH GRANT OPTION;


--
-- TOC entry 5235 (class 3466 OID 34918)
-- Name: issue_graphql_placeholder; Type: EVENT TRIGGER; Schema: -; Owner: postgres
--

CREATE EVENT TRIGGER issue_graphql_placeholder ON sql_drop
         WHEN TAG IN ('DROP EXTENSION')
   EXECUTE FUNCTION extensions.set_graphql_placeholder();


ALTER EVENT TRIGGER issue_graphql_placeholder OWNER TO postgres;

--
-- TOC entry 5236 (class 3466 OID 34919)
-- Name: issue_pg_cron_access; Type: EVENT TRIGGER; Schema: -; Owner: postgres
--

CREATE EVENT TRIGGER issue_pg_cron_access ON ddl_command_end
         WHEN TAG IN ('CREATE EXTENSION')
   EXECUTE FUNCTION extensions.grant_pg_cron_access();


ALTER EVENT TRIGGER issue_pg_cron_access OWNER TO postgres;

--
-- TOC entry 5237 (class 3466 OID 34920)
-- Name: issue_pg_graphql_access; Type: EVENT TRIGGER; Schema: -; Owner: postgres
--

CREATE EVENT TRIGGER issue_pg_graphql_access ON ddl_command_end
         WHEN TAG IN ('CREATE FUNCTION')
   EXECUTE FUNCTION extensions.grant_pg_graphql_access();


ALTER EVENT TRIGGER issue_pg_graphql_access OWNER TO postgres;

--
-- TOC entry 5238 (class 3466 OID 34921)
-- Name: issue_pg_net_access; Type: EVENT TRIGGER; Schema: -; Owner: postgres
--

CREATE EVENT TRIGGER issue_pg_net_access ON ddl_command_end
         WHEN TAG IN ('CREATE EXTENSION')
   EXECUTE FUNCTION extensions.grant_pg_net_access();


ALTER EVENT TRIGGER issue_pg_net_access OWNER TO postgres;

--
-- TOC entry 5239 (class 3466 OID 34922)
-- Name: pgrst_ddl_watch; Type: EVENT TRIGGER; Schema: -; Owner: postgres
--

CREATE EVENT TRIGGER pgrst_ddl_watch ON ddl_command_end
   EXECUTE FUNCTION extensions.pgrst_ddl_watch();


ALTER EVENT TRIGGER pgrst_ddl_watch OWNER TO postgres;

--
-- TOC entry 5240 (class 3466 OID 34923)
-- Name: pgrst_drop_watch; Type: EVENT TRIGGER; Schema: -; Owner: postgres
--

CREATE EVENT TRIGGER pgrst_drop_watch ON sql_drop
   EXECUTE FUNCTION extensions.pgrst_drop_watch();


ALTER EVENT TRIGGER pgrst_drop_watch OWNER TO postgres;

-- Completed on 2026-04-22 13:11:16

--
-- PostgreSQL database dump complete
--

\unrestrict kcwoJpA7FjfWzxdyG3NacALcbT2ByN4gK5zqppvgJEZLVWmVR6xZhngDWSivnqT

