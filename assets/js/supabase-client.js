/**
 * Supabase Client Setup
 * Initialize Supabase for client-side authentication and data access
 */

// Import Supabase from CDN
import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm';

// Get credentials from page (set by PHP)
const SUPABASE_URL = document.body.dataset.supabaseUrl || '';
const SUPABASE_ANON_KEY = document.body.dataset.supabaseKey || '';

// Create Supabase client
const supabase = createClient(SUPABASE_URL, SUPABASE_ANON_KEY);

// Auth helpers
const Auth = {
  async signUp(email, password) {
    const { data, error } = await supabase.auth.signUp({ email, password });
    return { data, error };
  },
  
  async signIn(email, password) {
    const { data, error } = await supabase.auth.signInWithPassword({ 
      email, 
      password 
    });
    return { data, error };
  },
  
  async signOut() {
    const { error } = await supabase.auth.signOut();
    return { error };
  },
  
  async getUser() {
    const { data: { user } } = await supabase.auth.getUser();
    return user;
  }
};

// Make available globally
window.supabase = supabase;
window.Auth = Auth;

export { supabase, Auth };