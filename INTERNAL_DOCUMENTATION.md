# INTERNAL_DOCUMENTATION.md - IW Flash Order

## 🆔 Identità del Plugin
**Nome:** IW Flash Order  
**Tagline:** Gestione ordini istantanei, tavoli e checkout rapido per WooCommerce.  
**Versione:** 1.0.0 (o come definito in `flash_order.php`)

---

## 💎 Proposta di Valore

### 📌 Problema Risolto
Il checkout standard di WooCommerce può essere lento e macchinoso per attività come ristoranti, cafè o negozi che necessitano di ordini rapidi sul posto. Flash Order elimina le barriere al checkout, permettendo ordini in pochi click e una gestione fluida dei tavoli.

### 🚀 Benefici Chiave
- **Velocità Estrema:** Un processo di checkout ottimizzato che riduce l'abbandono del carrello.
- **Gestione Tavoli Integrata:** Ideale per il settore HoReCa per monitorare gli ordini per ogni tavolo in tempo reale.
- **Mobile-First:** Interfaccia progettata per tablet e smartphone, perfetta per il personale di sala o l'auto-ordinazione dei clienti.

### 🌟 Unique Selling Points (USPs)
- **One-Click Ordering:** Esperienza utente ultra-veloce ispirata alle migliori app di food delivery.
- **Sincronizzazione Real-Time:** Gli ordini appaiono istantaneamente nella dashboard di gestione per il personale.
- **Flessibilità di Deployment:** Utilizzabile sia come catalogo digitale che come sistema di gestione ordini interno.

---

## 🎯 Marketing & Sales Copy Hooks

### **Target Audience**
- Ristoranti, Pizzerie e Cafè.
- Food Truck e Chioschi.
- Negozi con alto volume di vendite rapide al bancone.

### **Elevator Pitch**
"Velocizza le tue vendite e semplifica la gestione della sala con IW Flash Order. Il plugin che trasforma il tuo WooCommerce in un sistema POS moderno e in una piattaforma di ordinazione istantanea per i tuoi clienti, tutto in un'unica soluzione mobile-ready."

---

## 📖 Guida all'Utilizzo

### **Installazione e Configurazione**
1. Attiva il plugin.
2. Vai su **Settings** nel menu FlashOrder.
3. Clicca sul pulsante per generare automaticamente le pagine necessarie (Menu, Gestione Ordini, Tavoli).
4. In alternativa, posiziona gli shortcode/action nelle tue pagine custom:
   - Menu: `<?php do_action('FO_front_order_ajax_section'); ?>`
   - Gestione Ordini: `<?php do_action('FO_manage_order_section'); ?>`
   - Gestione Tavoli: `<?php do_action('FO_manage_tables_section'); ?>`

### **Funzionalità Core**
- **Dashboard Gestione Tavoli:** Visualizza lo stato di ogni tavolo e gli ordini attivi.
- **Interfaccia Ordini Rapidi:** Catalogo prodotti ottimizzato per la velocità di inserimento nel carrello.
- **Sistema di Notifiche:** Gestione degli status degli ordini (In preparazione, Pronto, Servito).

---

## 🛠 Riferimento Tecnico

### **Architettura**
Il plugin utilizza un sistema basato su Action Hook per il rendering delle sezioni front-end.
- `admin/`: Gestione delle impostazioni e pannelli amministrativi.
- `public/`: Asset e logica per il front-end dell'utente.
- `includes/`: Logica core e integrazione WooCommerce.

### **Hooks Principali**
- `FO_front_order_ajax_section`: Renderizza la sezione di ordinazione pubblica.
- `FO_manage_order_section`: Renderizza la dashboard di gestione ordini per il personale.
- `FO_manage_tables_section`: Renderizza il pannello di gestione tavoli.

### **Dipendenze**
- WooCommerce (necessario e attivo).
- PHP 7.4+

---

## 🗺 Roadmap
- [ ] Integrazione con stampanti termiche via cloud.
- [ ] Gestione inventario in tempo reale durante l'ordinazione flash.
- [ ] Modulo pagamenti self-service al tavolo via QR Code.
