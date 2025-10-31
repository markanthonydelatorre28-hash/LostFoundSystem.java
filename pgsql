private static void markAsFound() {
    System.out.print("\nEnter item ID to mark as FOUND: ");
    int id = getIntInput();

    for (Item i : items) {
        if (i.getId() == id) {
            if (i.getStatus().equalsIgnoreCase("lost")) {
                i.setStatus("found");
                System.out.println("✅ Item marked as FOUND!");
            } else {
                System.out.println("⚠️ Only lost items can be marked as found.");
            }
            return;
        }
    }
    System.out.println("Item ID not found.");
}
